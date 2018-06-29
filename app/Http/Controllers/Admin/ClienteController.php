<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Cliente;
use App\Boleta;
use App\Proyecto;
use App\Models\Auth\User\User;
use Ramsey\Uuid\Uuid;
use App\Models\Auth\Role\Role;
use DataTables;
use DB;


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
            'confirmed' => true
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

        $user_id = Cliente::select('user_id')->where('id',$request->id)->first();
        $user = User::find($user_id->user_id);
        $user->active = 1;
        $user->save();

        $respuesta["correcto"]=1;

        return  json_encode($respuesta);
    }

    public function deshabilitar(Request $request)
    {
        $respuesta= [];
        $cliente = Cliente::find($request->id);
        $cliente->habilitado= 0;
        $cliente->save();

        $user_id = Cliente::select('user_id')->where('id',$request->id)->first();
        $user = User::find($user_id->user_id);
        $user->active = 0;
        $user->save();

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

        return json_encode($cliente);

    }

    public function detalleProyectos(Request $request)
    {
        $respuesta= [];
        $cliente = Cliente::find($request->val);

        return json_encode($cliente->proyectos);

    }

    public function detalleAsociar($id)
    {
        $respuesta= [];
        $bag['cliente'] = Cliente::find($id);
        $bag['proyecto'] = Proyecto::all();

        return view('admin.cliente.detalle', ['bag' => $bag]);

    }

    public function asociar(Request $request)
    {
      $respuesta= [];
      $cliente = Cliente::find($request->cliente_id);
      $cliente->proyectos()->attach($request->proyecto_id);
      $cliente->save();

      $respuesta["correcto"]=1;

      return  json_encode($respuesta);

    }
    public function desasociar(Request $request)
    {
      $respuesta= [];
      $cliente = Cliente::find($request->cliente_id);
      $cliente->proyectos()->detach($request->proyecto_id);
      $cliente->save();

      $respuesta["correcto"]=1;

      return  json_encode($respuesta);

    }


    public function lista()
    {
        //
        return view('admin.cliente.lista');
    }
    public function listaTabla(){

      $cliente = Cliente::all();


    return Datatables::of($cliente)->addColumn('action', function ($dato) {
        $r= '<a href="'.route('admin.cliente.editar', $dato->id).'" class="btn btn-primary  btn-xs"><i class="glyphicon glyphicon-edit"></i>Editar</a> ';
        if($dato->habilitado==1) {
            $r .= '<a href="' . route('admin.cliente.deshabilitar', $dato->id) . '" class="deshabilitar btn btn-dark btn-xs"><i class="glyphicon glyphicon-edit"></i>Deshabilitar</a> ';
        }else{
            $r .= '<a href="' . route('admin.cliente.habilitar', $dato->id) . '" class="habilitar btn btn-default btn-xs"><i class="glyphicon glyphicon-edit"></i>Habilitar</a> ';
        }

        $r.='<a href="'.route('admin.cliente.asociar',$dato->id) .  '" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-edit"></i>Gestionar proyectos</a> ';
        $r.='<a href="'.route('admin.cliente.boleta', $dato->id) .  '" class="btn btn-default btn-xs"><i class="glyphicon glyphicon-edit"></i>Boletas</a> ';
        $r.='<a href="'.route('admin.cliente.eliminar',$dato->id) .  '" class="btn btn-danger btn-xs bt_eliminar"><i class="glyphicon glyphicon-edit"></i>Eliminar</a> ';

        return $r;
    })->editColumn('nombre', function ($dato) {
        return  $dato->nombre  . ' ' .$dato->apellido_paterno . ' ' . $dato->apellido_materno  ;
    })->editColumn('habilitado', function ($dato) {
        if($dato->habilitado == 1){
          return "Habilitado";
        }
        else {
          return "Deshabilitado";
        }
    })->editColumn('asociado', function ($dato) {


        if($dato->proyectos()->count()>0){
            $cli="Si";
            foreach($dato->proyectos()->get() as $pj    ){
                $cli.=" <br>[". $pj->nombre."]";
            }
          return  $cli;
        }
        else {
          return "No";
        }
    })->rawColumns(['asociado','action'])->make(true);

    /*->editColumn('tipo_propiedad_id', function ($dato) {
        return $dato->tipo_propiedad->nombre;
    })->editColumn('tipo_publicacion_id', function ($dato) {
        return $dato->tipo_publicacion->nombre;
    }) */
}

    public function boleta($id)
    {
      $bag = [];
      $bag['boleta'] = Boleta::where('cliente_id', $id);
      $bag['cliente'] = Cliente::find($id);
      return view('admin.cliente.boleta', ['bag' => $bag]);
    }

    public function boletaLista($id){

    $boleta = Boleta::select('id', 'periodo_id', 'f_emision', 'f_vencimiento', 'total' ,'estado_pago_id')->where('cliente_id', $id);

    return Datatables::of($boleta)->editColumn('periodo_id', function ($dato) {
        return  $dato->periodo->nombre;
      })->editColumn('estado_pago_id', function ($dato) {
          return  $dato->estado_pago->nombre;
      })->make(true);
    }

}
