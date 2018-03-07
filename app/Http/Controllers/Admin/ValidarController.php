<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ValidarController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index']]);
    }

    public function validarDB(Request $request)
    {
        $val=$request->val;
        $tabla=$request->tabla;
        $campo=$request->campo;
        //dd($request);
        $r = DB::table($tabla)->where($campo,$val)->count();
        //dd($cliente);
        if($r>0){
            return 1;
        }else{
            return 0;
        }
        //return "hola";
    }
}
