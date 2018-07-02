<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use App\Boleta;
use App\Cliente;

class CobranzaController extends Controller
{

  public function lista()
  {
      return view('admin.cobranza.lista');
  }
  public function listaTabla(){

    $boleta = Boleta::select('cliente_id', 'created_at')->where('estado_pago_id', 2)->distinct()->get();

    return Datatables::of($boleta)->addColumn('action', function ($dato) {
        $r= '<a href="'.route('admin.cobranza.detalle', $dato->cliente_id).'" class="btn btn-primary  btn-xs"><i class="glyphicon glyphicon-edit"></i>Ver detalles</a> ';
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

  public function detalleCobranza($id)
  {
      $respuesta= [];
      $bag['cliente'] = Cliente::find($id);
      $bag['boleta'] = Boleta::where('cliente_id', $id)->where('estado_pago_id', 2)->get();

      return view('admin.cobranza.detalle', ['bag' => $bag]);
  }

}
