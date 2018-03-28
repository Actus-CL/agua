<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Cliente;
use App\Models\Auth\User\User;
use Ramsey\Uuid\Uuid;
use App\Models\Auth\Role\Role;
use DataTables;


class ClienteController extends Controller
{
    /**
     * Determina si el rut recibido ya está ingresado en la base de datos,
     *  Devuelve TRUE si es que ya está ingresado, y False si no lo está
     * @param $rut
     * @return bool
     */



    public function nuevoForm()
    {
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


        $user = User::create([
            'name' => $cliente->nombreCompleto(),
            'email' => $request->email,
            'password' => bcrypt($request->rut),
            'confirmation_code' => Uuid::uuid4(),
            'confirmed' => false
        ]);

        $cliente->user_id = $user->id;
        $cliente->save();



        if (config('auth.users.default_role')) {
            $user->roles()->attach(Role::firstOrCreate(['name' => config('auth.users.default_role')]));
        }



        $respuesta["correcto"]=1;
        //$respuesta["mensajeOK"]="El cliente ha sido ingresado";
        //$respuesta["mensajeBAD"]="Ha ocurrido un problema y el cliente no ha logrado registrarse";
        //$respuesta["redireccion"]="hola";

         return  json_encode($respuesta);
    }

    public function editarForm($id)
    {
      $bag = [];
      $bag['cliente'] = Cliente::find($id);
      return view('admin.cliente.editar', ['bag' => $bag]);
    }

    public function editarUpdate(Request $request)
    {
        $respuesta= [];
        $cliente = Cliente::find($request->id);
        $cliente->nombre= $request->nombre;
        $cliente->apellido_paterno= $request->apellido_paterno;
        $cliente->apellido_materno= $request->apellido_materno;
        $cliente->rut= $request->rut;
        $cliente->email= $request->email;
        $cliente->direccion= $request->direccion;
        $cliente->save();

        $respuesta["correcto"]=1;

        return  json_encode($respuesta);
    }

    public function habilitar(Request $request)
    {
        $respuesta= [];
        $cliente = Cliente::find($request->id);
        $cliente->habilitado= 1;
        $cliente->save();

        $respuesta["correcto"]=1;

        return  json_encode($respuesta);
    }

    public function deshabilitar(Request $request)
    {
        $respuesta= [];
        $cliente = Cliente::find($request->id);
        $cliente->habilitado= 0;
        $cliente->save();

        $respuesta["correcto"]=1;

        return  json_encode($respuesta);
    }


    public function eliminar($id)
    {
        $respuesta= [];
        $cliente = Cliente::find($id);
        $cliente->delete();
        $respuesta["correcto"]=1;
        return json_encode($respuesta);
    }


    public function detalle(Request $request)
    {
        $respuesta= [];
        $cliente = Cliente::find($request->val);
        return  json_encode($cliente);
    }
    public function detalleProyectos(Request $request)
    {
        $respuesta= [];
        $cliente = Cliente::find($request->val);
        return  json_encode($cliente->proyectos);
    }

    public function lista()
    {
        //
        return view('admin.cliente.lista');
    }
    public function listaTabla(){

    $cliente = Cliente::all();

    return Datatables::of($cliente)->addColumn('action', function ($dato) {
        $r= '<a href="'.route('admin.cliente.editar', $dato).'" class="btn btn-primary  btn-xs"><i class="glyphicon glyphicon-edit"></i>Editar</a> ';
        if($dato->habilitado==1) {
            $r .= '<a href="' . route('admin.cliente.deshabilitar', $dato->id) . '" class="habilitar btn btn-dark btn-xs"><i class="glyphicon glyphicon-edit"></i>Deshabilitar</a> ';
        }else{
            $r .= '<a href="' . route('admin.cliente.habilitar', $dato->id) . '" class="deshabilitar btn btn-default btn-xs"><i class="glyphicon glyphicon-edit"></i>Habilitar</a> ';
        }

        $r.='<a href="'.route('admin.cliente.eliminar',$dato->id) .  '" class="btn btn-danger btn-xs bt_eliminar"><i class="glyphicon glyphicon-edit"></i>Eliminar</a> ';
        $r.='<a href="'.url('admin/propiedad/eliminar',$dato->id) .  '" class="btn btn-default btn-xs"><i class="glyphicon glyphicon-edit"></i>Boletas</a> ';

        return $r;
    })->editColumn('nombre', function ($dato) {
        return  $dato->nombre  . ' ' .$dato->apellido_paterno . ' ' . $dato->apellido_materno  ;
    })->make(true);

    /*->editColumn('tipo_propiedad_id', function ($dato) {
        return $dato->tipo_propiedad->nombre;
    })->editColumn('tipo_publicacion_id', function ($dato) {
        return $dato->tipo_publicacion->nombre;
    }) */
}

}
