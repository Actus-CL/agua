<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use App\Boleta;
use App\Cliente;

class RecaudacionController extends Controller
{

  public function lista()
  {
      return view('admin.recaudacion.lista');
  }
  public function listaTabla(){

    $boleta = Boleta::select('cliente_id', 'created_at')->where('estado_pago_id','<>', 3)->distinct()->get();

    return Datatables::of($boleta)->addColumn('action', function ($dato) {
        $r= '<a href="'.route('admin.recaudacion.detalle', $dato->cliente_id).'" class="btn btn-primary  btn-xs"><i class="glyphicon glyphicon-edit"></i>Ver detalles</a> ';
        return $r;
    })->editColumn('cliente_id', function ($dato) {
        $cliente = Cliente::find($dato->cliente_id);
        return  $cliente->nombreCompleto();
    })->editColumn('created_at', function ($dato) {
        $valores = Boleta::select('total')->where('cliente_id', $dato->cliente_id)->get();
        $final = 0;
        foreach($valores as $valor){
          $final += $valor->total;
        }
        return $final;
    })->make(true);
  }

  public function detalleRecaudacion($id)
  {
      $respuesta= [];
      $bag['cliente'] = Cliente::find($id);
      $bag['boleta'] = Boleta::where('cliente_id', $id)->where('estado_pago_id', '<>', 3)->get();

      return view('admin.recaudacion.detalle', ['bag' => $bag]);
  }

  public function pagarUpdate(Request $request)
  {
      $respuesta= [];
      $boleta = Boleta::where('cliente_id', $request->cliente_id)->where('estado_pago_id', '<>', 3)->get();

      foreach($boleta as $b){
        $b->estado_pago_id = 3;
        $b->save();
      }
      $respuesta["correcto"]=1;
      $respuesta["redireccion"]= route('admin.recaudacion.lista');

      return  json_encode($respuesta);
  }

}
