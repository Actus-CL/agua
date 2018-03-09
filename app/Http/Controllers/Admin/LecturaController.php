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
        $bag['periodos']=Periodo::all()->sortByDesc('id')->take(6)->reverse();//->pluck('serie','id') ;
        //dd($bag['periodos']);
        return view('admin.lectura.nuevo', ['bag' => $bag]);
    }

    public function detallePeriodo(Request $request)
    {
        //
        //$bag=[];
        //$bag['cliente']=Cliente::all();
        // $bag['medidor']=Medidor::where('asociado',1)->get();//->pluck('serie','id') ;
       //$bag['medidor']=Medidor::all();//->pluck('serie','id') ;
        $medidor_periodo=MedidorPeriodo::where('medidor_id',$request->medidor_id)->get()->sortByDesc('id')->take(6)->reverse();//->pluck('serie','id') ;
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
