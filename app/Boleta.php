<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Boleta extends Model
{
    protected $table = 'boleta';

    public function periodo()
    {
        return $this->belongsTo('App\Periodo' );
    }

    public function estado_pago()
    {
        return $this->belongsTo('App\EstadoPago', 'estado_pago_id' );
    }

    public function cuenta()
    {
        return $this->belongsTo('App\Cuenta', 'cuenta_id' );
    }

}
