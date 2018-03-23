<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medidor extends Model
{
    protected $table = 'medidor';
    public function medidor_modelo()
    {
        return $this->belongsTo('App\MedidorModelo' );
    }
    public function cuentas()
    {
        return $this->hasMany('App\Cuenta' );
    }
    public function ultima_lectura()
    {
        //dd($this->id);
        return Lectura::where("medidor_id", $this->id)->get()->sortByDesc('id')->take(1)->first();
    }

}
