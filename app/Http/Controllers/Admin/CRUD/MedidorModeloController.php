<?php

namespace App\Http\Controllers\Admin\CRUD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MedidorModelo;
use DataTables;

class MedidorModeloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.crud.medidor_modelo.lista');
    }

    public function tabla(){

      $medidormodelo = MedidorModelo::select('id', 'nombre')->get();

      return Datatables::of($medidormodelo)->addColumn('action', function ($dato) {
          return '<a href="'.route('admin.medidormodelo.show', $dato->id).'" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i>Editar</a> ';
          })->make(true);

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.crud.medidor_modelo.nuevo');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $respuesta= [];
      $medidormodelo = new MedidorModelo();
      $medidormodelo->nombre= $request->nombre;
      $medidormodelo->save();

      $respuesta["correcto"]=1;

      return  json_encode($respuesta);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $bag = [];
      $bag['medidormodelo'] = MedidorModelo::find($id);
      return view('admin.crud.medidor_modelo.editar', ['bag' => $bag]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      $respuesta= [];
      $medidormodelo = MedidorModelo::find($request->id);
      $medidormodelo->nombre= $request->nombre;
      $medidormodelo->save();

      $respuesta["correcto"]=1;

      return  json_encode($respuesta);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
