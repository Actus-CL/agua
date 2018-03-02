<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Cliente;


class ClienteController extends Controller
{
    /**
     * Determina si el rut recibido ya está ingresado en la base de datos,
     *  Devuelve TRUE si es que ya está ingresado, y False si no lo está
     * @param $rut
     * @return bool
     */
    public function validarRut(Request $request)
    {
       /* $cliente = Cliente::where("rut",$request->rut);
        if($cliente){
            return true;
       }else{
            return false;
        }*/
       return "hola";
    }

    public function nuevoForm()
    {
        //
        return view('admin.cliente.nuevo');
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

        $respuesta["correcto"]=0;
        //$respuesta["mensajeOK"]="El cliente ha sido ingresado";
        //$respuesta["mensajeBAD"]="Ha ocurrido un problema y el cliente no ha logrado registrarse";
        //$respuesta["redireccion"]="hola";

         return  json_encode($respuesta);
    }

    public function lista()
    {
        //
        return view('admin.cliente.lista');
    }
    public function listaTabla(){

        $propiedades = Propiedad::select(['id','titulo','tipo_propiedad_id','tipo_publicacion_id']);

        return Datatables::of($propiedades)->addColumn('action', function ($dato) {
            return '<a href="'.url('admin/propiedad/editar', $dato).'" class="btn green-meadow btn-xs"><i class="glyphicon glyphicon-edit"></i>Editar</a> 
                            <a href="'.url('admin/propiedad/foto', $dato).'" class="btn yellow-crusta btn-xs"><i class="glyphicon glyphicon-edit"></i>Añadir fotografías</a> 
                              <a href="'.url('admin/propiedad/eliminar',$dato->id) .  '" class="btn red-crusta btn-xs"><i class="glyphicon glyphicon-edit"></i>Eliminar</a> 
                             ';
        })->editColumn('tipo_propiedad_id', function ($dato) {
            return $dato->tipo_propiedad->nombre;
        })->editColumn('tipo_publicacion_id', function ($dato) {
            return $dato->tipo_publicacion->nombre;
        })->make(true);
    }

}
