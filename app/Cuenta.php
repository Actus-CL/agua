<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Cuenta extends Model
{
    protected $table = 'cuenta';
    public function medidor()
    {
        return $this->belongsTo('App\Medidor' );
    }
    public function cliente()
    {
        return $this->belongsTo('App\Cliente' );
    }
    public function proyecto()
    {
        return $this->belongsTo('App\Proyecto' );
    }
    public function cuentaEstado()
    {
        return $this->belongsTo('App\CuentaEstado' );
    }
    public function servicios()
    {
        return $this->belongsToMany('App\Servicio' ,'cuentaservicio');
    }
    public function boletas()
    {
        return $this->hasMany('App\Boleta' );
    }
}
