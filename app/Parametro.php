<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parametro extends Model
{
    protected $table = 'parametro';



    public static  function nombre($nombre)
    {
        return Parametro::where("nombre",$nombre)->first()->valor;
    }
}
