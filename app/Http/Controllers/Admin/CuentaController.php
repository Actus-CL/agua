<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Cliente;
use App\Medidor;
use App\Cuenta;
use DataTables;

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
        })->make(true);

        /*->editColumn('tipo_propiedad_id', function ($dato) {
            return $dato->tipo_propiedad->nombre;
        })->editColumn('tipo_publicacion_id', function ($dato) {
            return $dato->tipo_publicacion->nombre;
        }) */
    }


}
