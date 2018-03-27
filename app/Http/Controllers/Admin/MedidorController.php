<?php

namespace App\Http\Controllers\Admin;

use App\Medidor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MedidorModelo;
use DataTables;
class MedidorController extends Controller
{

    public function nuevoForm()
    {
        //
        $bag=[];
        $bag['medidor_modelo']=MedidorModelo::all()->pluck('nombre','id');
        return view('admin.medidor.nuevo', ['bag' => $bag]);
    }

    public function detalle(Request $request)
    {
        $respuesta= [];
        $respuesta['medidor'] = Medidor::find($request->val);
        $respuesta['modelo'] = MedidorModelo::all()->pluck('nombre','id');
        return  json_encode($respuesta);
    }

    public function listadoAutocomplete(Request $request)
    {
         $medidor= Medidor::where('serie','like','%'.$request->querys.'%')->get();
        $medidor=$medidor->pluck('serie','id');
        foreach($medidor as $k=>$m){
            //dd($m);
            $medidorArray[]= array( 'value'=> "$k", 'data'=> $m);
        }
        return  json_encode($medidorArray);
    }

    public function nuevoStore(Request $request)
    {
        $respuesta= [];
        $medidor = new Medidor();
        $medidor->serie= $request->serie;
        $medidor->medidor_modelo_id= $request->medidor_modelo_id;
        $medidor->lectura_inicial= $request->lectura_inicial;
        $medidor->lectura_ultima= $request->lectura_inicial;
        $medidor->save();

        $respuesta["correcto"]=1;
        //$respuesta["mensajeOK"]="El cliente ha sido ingresado";
        //$respuesta["mensajeBAD"]="Ha ocurrido un problema y el cliente no ha logrado registrarse";
        //$respuesta["redireccion"]="hola";

        return  json_encode($respuesta);
    }

    public function lista()
    {
        //
        return view('admin.medidor.lista');
    }
    public function listaTabla(){

        $m = Medidor::all();

        return Datatables::of($m)->addColumn('action', function ($d) {
            $r= '<a href="'.route('admin.medidor.editar', $d).'" class="btn btn-primary  btn-xs"><i class="glyphicon glyphicon-edit"></i>Editar</a>  ';
            return $r;
        })->addColumn('medidor_modelo', function ($dato) {
            return  $dato->medidor_modelo->nombre;
        })->addColumn('cliente', function ($dato) {
            $r="";

            $cuentas=$dato->cuentas;
               foreach($cuentas as $c){
                $r .= $c->cuentaEstado->nombre . ' (' . $c->cliente->nombreCompleto().') ';
            }
            return $r;

           // return  'holi';//$dato->nombre  . ' ' .$dato->apellido_paterno . ' ' . $dato->apellido_materno  ;
        })->editColumn('asociado', function ($dato) {
            $r="No";
            if($dato->asociado==1){
                $r="Si";
            }
            return $r;
        })->make(true);

        /*->editColumn('tipo_propiedad_id', function ($dato) {
            return $dato->tipo_propiedad->nombre;
        })->editColumn('tipo_publicacion_id', function ($dato) {
            return $dato->tipo_publicacion->nombre;
        }) */
    }

    public function editarForm($id)
    {
      $bag = [];
      $bag['medidor'] = Medidor::find($id);
      $bag['medidor_modelo']= MedidorModelo::all()->pluck('nombre','id');
      return view('admin.medidor.editar', ['bag' => $bag]);
    }

    public function editarUpdate(Request $request)
    {
        $respuesta= [];
        $medidor = Medidor::find($request->id);
        $medidor->medidor_modelo_id= $request->medidor_modelo_id;
        $medidor->lectura_inicial= $request->lectura_inicial;
        $medidor->lectura_ultima= $request->lectura_ultima;
        $medidor->save();

        $respuesta["correcto"]=1;

        return  json_encode($respuesta);
    }

    // public function eliminar($id)
    // {
    //     $respuesta= [];
    //     $medidor = Medidor::find($id);
    //     $medidor->delete();
    //     $respuesta["correcto"]=1;
    //     return json_encode($respuesta);
    // }
}
