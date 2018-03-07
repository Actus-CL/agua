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
}
