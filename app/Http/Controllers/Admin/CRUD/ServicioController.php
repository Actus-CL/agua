<?php

namespace App\Http\Controllers\Admin\CRUD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Servicio;
use DataTables;

class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.crud.servicio.lista');
    }

    public function tabla(){

      $servicio = Servicio::select('id', 'nombre', 'total')->get();

      return Datatables::of($servicio)->addColumn('action', function ($dato) {
          return '<a href="'.route('admin.servicio.show', $dato->id).'" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i>Editar</a> ';
          })->make(true);

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.crud.servicio.nuevo');
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
      $servicio = new Servicio();
      $servicio->nombre= $request->nombre;
      $servicio->total= $request->total;
      $servicio->save();

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
      $bag['servicio'] = Servicio::find($id);
      return view('admin.crud.servicio.editar', ['bag' => $bag]);
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
      $servicio = Servicio::find($request->id);
      $servicio->nombre= $request->nombre;
      $servicio->total= $request->total;
      $servicio->save();

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
