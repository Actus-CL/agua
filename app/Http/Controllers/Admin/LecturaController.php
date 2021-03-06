<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Medidor;
use App\Periodo;
use App\MedidorPeriodo;
use App\Lectura;
use App\Parametro;
use App\CuentaServicio;
use App\Cuenta;
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

        //dd($request->medidor_id);

        $medidor=Medidor::find($request->medidor_id);




        $lectura_existe=Lectura::where("medidor_id", $request->medidor_id)->where("periodo_id", $request->l_periodo_id)->get()->first();

        $lectura_anterior= Lectura::where("medidor_id", $request->medidor_id)->get()->sortByDesc('id')->take(6)->first();

        //

       // dd($lectura_existe);
        if($lectura_existe){
            $respuesta["correcto"]=0;
            $respuesta["mensajeBAD"]="Ya existe una lectura ingresada para este periodo";
        } else if($request->lectura_actual < $medidor->lectura_ultima){
            $respuesta["correcto"]=0;
            $respuesta["mensajeBAD"]="La nueva lectura es menor a la anterior";
        }else{
            $lectura = new Lectura();
            $lectura->anterior =$medidor->lectura_ultima;
            $lectura->medidor_id =$medidor->id;
            $lectura->actual =$request->lectura_actual;
            $lectura->periodo_id = $request->l_periodo_id;
            $diferencia=$request->lectura_actual-$medidor->lectura_ultima;
            $lectura->diferencia =$diferencia;
            $lectura->save();

            $medidor->lectura_ultima=$request->lectura_actual;
             $medidor->save();


            $periodos_repartir=0;
            $carga_mensual=0;
             if($lectura_anterior){

                $periodos_repartir= $lectura->periodo->id - $lectura_anterior->periodo->id;
                //if($periodos_repartir>0)
                $carga_mensual=$diferencia / $periodos_repartir;

                $periodo_inicial=$lectura_anterior->periodo->id+1;
                $periodo_final=$lectura->periodo->id;
                if ($periodo_inicial!=$periodo_final){
                    for ($periodo_aux=$periodo_inicial;$periodo_final; $periodo_aux++){

                        $medidor_periodo= new MedidorPeriodo();
                        $medidor_periodo->medidor_id=$medidor->id;
                        $medidor_periodo->consumo_promedio=$carga_mensual;
                        $medidor_periodo->periodo_id=$periodo_aux;
                         $medidor_periodo->save();
                    }
                }else{
                    $medidor_periodo= new MedidorPeriodo();
                    $medidor_periodo->medidor_id=$medidor->id;
                    $medidor_periodo->consumo_promedio=$carga_mensual;
                    $medidor_periodo->periodo_id=$periodo_inicial;
                     $medidor_periodo->save();
                }


                //Aplicar sobrecargo
                $tope_mensual= Parametro::nombre("consumo_mensual_maximo");
               // dd($carga_mensual);
                if($carga_mensual>$tope_mensual){
                    $cuenta= Cuenta::where("medidor_id",$medidor->id)->first();

                    $sobrecargo= new CuentaServicio();
                    $sobrecargo->cuenta_id=$cuenta->id;
                    $sobrecargo->servicio_id=3;
                    $sobrecargo->save();

                }


            }



            $respuesta["correcto"]=1;
            //$respuesta["mensajeOK"]="El cliente ha sido ingresado";

        }







        /*$cliente = new Cliente();
        $cliente->nombre= $request->nombre;
        $cliente->apellido_paterno= $request->apellido_paterno;
        $cliente->apellido_materno= $request->apellido_materno;
        $cliente->rut= $request->rut;
        $cliente->email= $request->email;
        $cliente->direccion= $request->direccion;
        $cliente->save();
*/





        //$respuesta["mensajeBAD"]="Ha ocurrido un problema y el cliente no ha logrado registrarse";
        //$respuesta["redireccion"]="hola";

        return  json_encode($respuesta);
    }
}
