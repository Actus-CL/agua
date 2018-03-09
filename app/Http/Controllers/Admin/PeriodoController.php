<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Periodo;
use DataTables;
class PeriodoController extends Controller
{
    public function nuevoForm()
    {
        //
        $bag=[];
        $p=Periodo::all()->sortBy('id')->last();
        $mes=$p->mes+1;
        $anio=$p->anio;
        if( $mes>12){
            $anio++;
            $mes=1;
        }
        if($mes<10)
        {
            $mes='0'.$mes;
        }
         //dd($p->desde);
        $bag['mes']=$mes;
        $bag['anio']=$anio;
        $bag['nombre']=$mes.$anio;
        $bag['desde']='';$p->desde;
        $bag['ultimo']=$p;
        return view('admin.periodo.nuevo', ['bag' => $bag]);
    }


    public function nuevoStore(Request $request)
    {
        $respuesta= [];
        $p = new Periodo();
        $p->nombre= $request->nombre;
        $p->anio= $request->anio;
        $p->mes= $request->mes;
        $p->activo= 0;
        $p->save();

        $respuesta["correcto"]=1;
        //$respuesta["mensajeOK"]="El cliente ha sido ingresado";
        //$respuesta["mensajeBAD"]="Ha ocurrido un problema y el cliente no ha logrado registrarse";
        //$respuesta["redireccion"]="hola";

        return  json_encode($respuesta);
    }

    public function lista()
    {
        //
        return view('admin.periodo.lista');
    }
    public function listaTabla(){

        $m = Periodo::all();
        //dd($m);
        return Datatables::of($m)->addColumn('action', function ($d) {
            $r= '<a href="'.route('admin.cliente.editar', $d).'" class="btn btn-primary  btn-xs"><i class="glyphicon glyphicon-edit"></i>Editar</a> ';
            $r.= '<a href="'.route('admin.cliente.editar', $d).'" class="btn btn-primary  btn-xs"><i class="glyphicon glyphicon-edit"></i>Boletas</a> ';
            if($d->activo_lectura==0){
                $r.= '<a href="'.route('admin.periodo.activar.lectura', $d).'" class="btn btn-primary  btn-xs"><i class="glyphicon glyphicon-edit"></i>Activar Lectura</a> ';
            }
            if($d->activo_facturacion==0){
                $r.= '<a href="'.route('admin.periodo.activar.facturacion', $d).'" class="btn btn-primary  btn-xs"><i class="glyphicon glyphicon-edit"></i>Activar facturacion</a> ';
            }
             return $r;
        })->editColumn('activo_facturacion', function ($dato) {
            $r="No";
             if($dato->activo_facturacion==1){
                $r="Si";
            }
            return $r;
        })->editColumn('activo_lectura', function ($dato) {
            $r="No";
            if($dato->activo_lectura==1){
                $r="Si";
            }
            return $r;
        })->make(true);
    }

    public function habilitarLectura($id)
    {
        $respuesta= [];
        Periodo::where('activo_lectura',1)->each(function($sp){
            $sp->activo_lectura= 0;
            $sp->save();
        });
        $p = Periodo::find($id);
        $p->activo_lectura= 1;
        $p->save();
        $respuesta["correcto"]=1;
        return  redirect(route('admin.periodo.lista'));
    }

    public function habilitarFacturacion($id)
    {
        $respuesta= [];
        Periodo::where('activo_facturacion',1)->each(function($sp){
            $sp->activo_facturacion= 0;
            $sp->save();
        });
        $p = Periodo::find($id);
        $p->activo_facturacion= 1;
        $p->save();
        $respuesta["correcto"]=1;
        return  redirect(route('admin.periodo.lista'));
    }




}
