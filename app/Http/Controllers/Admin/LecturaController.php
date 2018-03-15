<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Medidor;
use App\Periodo;
use App\MedidorPeriodo;

class LecturaController extends Controller
{
    public function nuevoForm()
    {
        //
        $bag=[];
        //$bag['cliente']=Cliente::all();
       // $bag['medidor']=Medidor::where('asociado',1)->get();//->pluck('serie','id') ;
        $bag['medidor']=Medidor::all();//->pluck('serie','id') ;
        $periodo_lec=Periodo::where("activo_lectura",1)->first();
        $bag['periodo_lec']=$periodo_lec;
        $bag['periodos']=Periodo::where("id","<=",$periodo_lec->id)->get()->sortByDesc('id')->take(6)->reverse();//->pluck('serie','id') ;
        //dd($bag['periodos']);
        return view('admin.lectura.nuevo', ['bag' => $bag]);
    }

    public function detallePeriodo(Request $request)
    {
        //
        //$bag=[];
        //$bag['cliente']=Cliente::all();
        // $bag['medidor']=Medidor::where('asociado',1)->get();//->pluck('serie','id') ;
        $periodo_f= Periodo::where('activo_facturacion',1)->first();
        $medidor_periodo=MedidorPeriodo::where('medidor_id',$request->medidor_id)->where('id','<=',$periodo_f->id)->get()->sortByDesc('id')->take(6)->reverse();//->pluck('serie','id') ;
        //dd($bag['medidor_periodo']);
        return json_encode($medidor_periodo);
    }




    public function nuevoStore(Request $request)
    {
        $respuesta= [];
        $cliente = new Cliente();
        $cliente->nombre= $request->nombre;
        $cliente->apellido_paterno= $request->apellido_paterno;
        $cliente->apellido_materno= $request->apellido_materno;
        $cliente->rut= $request->rut;
        $cliente->email= $request->email;
        $cliente->direccion= $request->direccion;
        $cliente->save();





        $respuesta["correcto"]=1;
        //$respuesta["mensajeOK"]="El cliente ha sido ingresado";
        //$respuesta["mensajeBAD"]="Ha ocurrido un problema y el cliente no ha logrado registrarse";
        //$respuesta["redireccion"]="hola";

        return  json_encode($respuesta);
    }
}
