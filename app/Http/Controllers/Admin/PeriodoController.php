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
use Carbon\Carbon;
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
        $bag['desde']=$p->hasta->addDays(1);
        $bag['hasta']=$p->hasta->addMonths(1);

        $bag['pago']=$p->f_vencimiento_pago->addMonths(1);
        $bag['corte']=$p->f_vencimiento_corte->addMonths(1);
        $bag['ultimo']=$p;
        return view('admin.periodo.nuevo', ['bag' => $bag]);
    }


    public function nuevoStore(Request $r)
    {
        $respuesta= [];
        $respuesta["correcto"]=0;

        if($r->desde > $r->hasta){
            $respuesta["mensajeBAD"]="La fecha de termino del periodo debe ser inferior a la de inicio";
        }else if($r->f_vencimiento_pago > $r->f_vencimiento_corte){
            $respuesta["mensajeBAD"]="La fecha de corte debe ser superior a la de pago";
        }else if($r->f_vencimiento_pago < $r->hasta){
            $respuesta["mensajeBAD"]="La fecha de pago debe ser posterior al periodo";
        }else{
            $p = new Periodo();
            $p->nombre= $r->nombre;
            $p->anio= $r->anio;
            $p->mes= $r->mes;
            $p->activo_lectura= 0;
            $p->activo_facturacion= 0;
            $p->desde=$r->desde;
            $p->hasta=$r->hasta;

            $p->f_vencimiento_pago=$r->f_vencimiento_pago;
            $p->f_vencimiento_corte=$r->f_vencimiento_corte;
            $p->save();

            $respuesta["correcto"]=1;
        }



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
            $r= '<a href="'.route('admin.periodo.editar', $d).'" class="btn btn-primary  btn-xs"><i class="glyphicon glyphicon-edit"></i>Editar</a> ';
            $r.= '<a href="'.route('admin.periodo.boleta', $d->id).'" class="btn btn-primary  btn-xs"><i class="glyphicon glyphicon-edit"></i>Boletas</a> ';
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

    public function editarForm($id)
    {
      $bag = [];
      $bag['periodo'] = Periodo::find($id);
      return view('admin.periodo.editar', ['bag' => $bag]);
    }

    public function editarUpdate(Request $request)
    {
        $respuesta= [];
        $periodo = Periodo::find($request->id);
        //True si
        //ambos vencimientos son superiores a fecha 'hasta'
        //fecha de corte es superior a pago
        //fecha de pago es inferior a corte

        if($request->f_vencimiento_corte < $request->hasta){
          $respuesta["correcto"]=0;
          $respuesta["mensajeBAD"]="Fecha de corte debe ser superior a fecha 'hasta' ";
        }else if($request->f_vencimiento_pago < $request->hasta){
          $respuesta["correcto"]=0;
          $respuesta["mensajeBAD"]="Fecha de pago debe ser superior a fecha 'hasta' ";
        }else if ($request->f_vencimiento_corte < $request->f_vencimiento_pago) {
          $respuesta["correcto"]=0;
          $respuesta["mensajeBAD"]="Fecha de corte debe ser superior a la de pago";
        }else if ($request->f_vencimiento_pago > $request->f_vencimiento_corte) {
          $respuesta["correcto"]=0;
          $respuesta["mensajeBAD"]="Fecha de pago debe ser inferior a la de corte";
        }else if ($request->f_vencimiento_pago == $request->f_vencimiento_corte) {
          $respuesta["correcto"]=0;
          $respuesta["mensajeBAD"]="Fechas no pueden ser iguales";
        }else {
          $periodo->f_vencimiento_pago= $request->f_vencimiento_pago;
          $periodo->f_vencimiento_corte= $request->f_vencimiento_corte;
          $periodo->desde= $request->desde;
          //falta validación de fechas. Donde desde (actual) no debe ser inferior al hasta (anterior)
          $periodo->hasta= $request->hasta;
          $periodo->save();
          $respuesta["correcto"]=1;
        }
        // $respuesta["correcto"]=1;

        return  json_encode($respuesta);
    }

    public function boleta($id)
    {
      $bag = [];
      $bag['boleta'] = Boleta::where('periodo_id', $id);
      $bag['periodo'] = Periodo::find($id);
      return view('admin.periodo.boleta', ['bag' => $bag]);
    }

    public function boletaLista($id){

    $boleta = Boleta::select('id', 'cuenta_id', 'f_emision', 'f_vencimiento', 'total' ,'estado_pago_id')->where('periodo_id', $id);

    return Datatables::of($boleta)->editColumn('cuenta_id', function ($dato) {
        return  $dato->cuenta->id;
      })->editColumn('estado_pago_id', function ($dato) {
          return  $dato->estado_pago->nombre;
      })->make(true);
    }


}
