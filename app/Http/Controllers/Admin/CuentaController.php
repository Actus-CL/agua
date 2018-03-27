<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Cliente;
use App\Medidor;
use App\Cuenta;
use App\CuentaServicio;
use DataTables;
use DB;

class CuentaController extends Controller
{
    public function nuevoForm()
    {
        //
        $bag=[];
        $bag['cliente']=Cliente::all();
        $bag['medidor']=Medidor::where('asociado',0)->pluck('serie','id') ;
        return view('admin.cuenta.nuevo', ['bag' => $bag]);
    }

    public function listaClientesTabla(){

        $m = Cliente::all();

        return Datatables::of($m)->addColumn('action', function ($d) {
            //$r= '<a href="'.route('admin.cliente.editar', $d).'" class="btn btn-primary  btn-xs"><i class="glyphicon glyphicon-edit"></i>Editar</a> ';
            //$r.='<a href="'.url('admin/propiedad/eliminar',$d->id) .  '" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-edit"></i>Eliminar</a> ';
            $r =' <input type="radio" value="'.$d->id.'" id="optionsRadios1" name="optionsRadios" class="rbseleccionar"> Seleccionar'   ;
            return $r;
        })->editColumn('nombre', function ($dato) {
            return  $dato->nombre  . ' ' .$dato->apellido_paterno . ' ' . $dato->apellido_materno  ;
        })->make(true);

        /*->editColumn('tipo_propiedad_id', function ($dato) {
            return $dato->tipo_propiedad->nombre;
        })->editColumn('tipo_publicacion_id', function ($dato) {
            return $dato->tipo_publicacion->nombre;
        }) */
    }


    public function nuevoStore(Request $request)
    {
       // dd($request);

        $respuesta= [];

        $c = new Cuenta();
        $c->proyecto_id= $request->proyecto_id;
        $c->cliente_id= $request->cliente_id;
        $c->medidor_id= $request->medidor_id;
        $c->cuenta_estado_id= 1;
        $c->save();


        $m = Medidor::find($request->medidor_id);
        $m->asociado= 1;
        $m->save();


        $ncs= new CuentaServicio();
        $ncs->cuenta_id=$c->id;
        $ncs->servicio_id=1;
        $ncs->save();


        $respuesta["correcto"]=1;
        $respuesta["mensajeOK"]="Se ha creado la cuenta";
        //$respuesta["mensajeBAD"]="Ha ocurrido un problema y el cliente no ha logrado registrarse";
        //$respuesta["redireccion"]="hola";


        return  json_encode($respuesta);
    }

    public function lista()
    {
        //
        return view('admin.cuenta.lista');
    }
    public function listaTabla(){

        $m = Cuenta::all();

        return Datatables::of($m)->addColumn('action', function ($d) {
            $r= '<a href="'.route('admin.cliente.editar', $d).'" class="btn btn-primary  btn-xs"><i class="glyphicon glyphicon-edit"></i>Boletas</a> ';
            $r.= '<a href="'.route('admin.cliente.editar', $d).'" class="btn btn-primary  btn-xs"><i class="glyphicon glyphicon-edit"></i>Estado</a> ';
            $r.= '<a href="'.route('admin.cliente.editar', $d).'" class="btn btn-primary  btn-xs"><i class="glyphicon glyphicon-edit"></i>Servicios</a> ';
            return $r;
        })->addColumn('proyecto', function ($dato) {
            return  $dato->proyecto->nombre;
        })->addColumn('cliente', function ($c) {
            $r  = $c->cliente->nombreCompleto();
            return $r;
        })->addColumn('medidor', function ($c) {
            $r  = $c->medidor->serie;
            return $r;
        })->addColumn('cuenta_estado', function ($c) {
            $r = $c->cuentaEstado->nombre;
            return $r;
        })->addColumn('bt_instalado', function ($d) {
            $r='';
            if($d->cuenta_estado_id!=1){
                $r.= '<a href="'.route('admin.cuenta.estado.cambiar', [$d,1]).'" class="btn btn-primary  btn-xs"><i class="glyphicon glyphicon-edit"></i>Activar</a> ';
            }
            return $r;
        })->addColumn('bt_habilitado', function ($d) {
            $r='';
            if($d->cuenta_estado_id!=2){
                $r.= '<a href="'.route('admin.cuenta.estado.cambiar', [$d,2]).'" class="btn btn-primary  btn-xs"><i class="glyphicon glyphicon-edit"></i>Activar</a> ';
            }
            return $r;
        })->addColumn('bt_suspendido', function ($d) {
            $r='';
            if($d->cuenta_estado_id!=3){
                $r.= '<a href="'.route('admin.cuenta.estado.cambiar', [$d,3]).'" class="btn btn-primary  btn-xs"><i class="glyphicon glyphicon-edit"></i>Activar</a> ';
            }
            return $r;
        })->addColumn('bt_retirado', function ($d) {
            $r='';
            if($d->cuenta_estado_id!=4){
                $r.= '<a href="'.route('admin.cuenta.estado.cambiar', [$d,4]).'" class="btn btn-primary  btn-xs"><i class="glyphicon glyphicon-edit"></i>Activar</a> ';
            }
            return $r;
        })->editColumn('nombre', function ($dato) {
            return  $dato->nombre  . ' ' .$dato->apellido_paterno . ' ' . $dato->apellido_materno  ;
        })->rawColumns(['bt_retirado', 'bt_suspendido','bt_habilitado','bt_instalado','action'])->make(true);

        /*->editColumn('tipo_propiedad_id', function ($dato) {
            return $dato->tipo_propiedad->nombre;
        })->editColumn('tipo_publicacion_id', function ($dato) {
            return $dato->tipo_publicacion->nombre;
        }) */
    }





    public function cambioEstado($id,$cuenta_estado_id)
    {
       $c= Cuenta::find($id);
        $c->cuenta_estado_id=$cuenta_estado_id;
        $c->save();

       // $css= CuentaServicio::where("cuenta_id",$c->id)->get();



        //$eliminar= DB::query("Delete from cuentaservicio where cuenta_id=".$c->id);
        $deleted = DB::delete("delete from users where cuenta_id=?",[$c->id]);
        //$eliminar->

        if($cuenta_estado_id==1){
            $ncs= new CuentaServicio();
            $ncs->cuenta_id=$c->id;
            $ncs->servicio_id=1;
            $ncs->save();
        } elseif($cuenta_estado_id==2){
            $ncs= new CuentaServicio();
            $ncs->cuenta_id=$c->id;
            $ncs->servicio_id=2;
            $ncs->save();
        }


        return redirect(route("admin.cuenta.lista"));
    }
}
