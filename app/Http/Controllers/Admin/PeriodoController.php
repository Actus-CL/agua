<?php

namespace App\Http\Controllers\Admin;

use App\Cuenta;
use App\MedidorPeriodo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Periodo;
use App\Medidor;
use App\Parametro;
use App\Boleta;
use App\BoletaDetalle;
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
        $p->activo_lectura= 0;
        $p->activo_facturacion= 0;
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
            return $r;
        })->addColumn('action_lectura', function ($d) {
            $r='';
            if($d->activo_lectura==0){
                $r.= '<a href="'.route('admin.periodo.activar.lectura', $d).'" class="btn btn-primary  btn-xs"><i class="glyphicon glyphicon-edit"></i>Activar</a> ';
            }

            return $r;
        })->addColumn('action_facturacion', function ($d) {
            $r='';
            if($d->activo_facturacion==0){
                $r.= '<a href="'.route('admin.periodo.activar.facturacion', $d).'" class="btn btn-primary  btn-xs"><i class="glyphicon glyphicon-edit"></i>Activar</a> ';
            }
            return $r;
        })->editColumn('activo_facturacion', function ($dato) {
            $r="No";
             if($dato->activo_facturacion==1){
                $r="Si";
            }
            return $r;
        })->editColumn('emitido', function ($dato) {
            $r="No";
            if($dato->emitido==1){
                $r="Si";
            }
            return $r;
        })->editColumn('activo_lectura', function ($dato) {
            $r="No";
            if($dato->activo_lectura==1){
                $r="Si";
            }
            return $r;
        })->rawColumns(['action_lectura', 'action_facturacion','action'])->make(true);
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
    public function facturar()
    {
        $bag=[];

         $bag['p']=Parametro::all()->pluck('valor','nombre')  ;
        $bag['medidor']=Medidor::all();//->pluck('serie','id') ;
        $periodo_lec=Periodo::where("activo_facturacion",1)->first();
        $bag['periodo_fac']=$periodo_lec;
        $bag['periodos']=Periodo::where("id","<=",$periodo_lec->id)->get()->sortByDesc('id')->take(6)->reverse();//->pluck('serie','id') ;
        //dd($bag['periodos']);
        return view('admin.periodo.facturar', ['bag' => $bag]);
    }
    public function facturarGuardar(Request $request)
    {
         $periodo_fac=Periodo::where("activo_facturacion",1)->first();
        $periodo_fac->emitido=1;
        $periodo_fac->save();


        $cuentas=Cuenta::where("cuenta_estado_id","<=",2)->get();

        foreach ($cuentas as $cuenta) {
            $medidor_periodo = new MedidorPeriodo();
            $medidor_periodo->medidor_id=$cuenta->medidor_id;
            $medidor_periodo->periodo_id=$periodo_fac->id;
            $medidor_periodo->consumo_promedio=$request->consumo_mensual_maximo;
            $medidor_periodo->save();

            $b= new Boleta();
            $b->cuenta_id=$cuenta->id;
            $b->cliente_id=$cuenta->cliente_id;
            $b->periodo_id=$periodo_fac->id;
            $b->total=100;
            $b->f_vencimiento=$periodo_fac->f_vencimiento_pago;
            $b->save();


            $servicios= $cuenta->servicios;
            foreach ($servicios as $servicio) {
                $bd= new BoletaDetalle();
                $bd->boleta_id=$b->id;
                $bd->servicio_id=$servicio->id;
                $bd->save();

            }



            //dd($cuentas);
        }


        // Eliminar todos los cobros del servicio sobrecargo en la tabla cuenta servicio


        $respuesta["correcto"]=1;
        $respuesta["mensajeOK"]="Se han emitido los cobros correspondientes";
        //$respuesta["mensajeBAD"]="Ha ocurrido un problema y el cliente no ha logrado registrarse";
        //$respuesta["redireccion"]="hola";

        return  json_encode($respuesta);
    }


}
