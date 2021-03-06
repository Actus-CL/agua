<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\Auth\User\User;

class Cliente extends Model
{
    protected $table = 'cliente';

    public function proyectos()
    {
        return $this->belongsToMany('App\Proyecto' ,'cliente_proyecto');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\Auth\User\User' ,'user_id' );
    }
    public function nombreCompleto()
    {
        return $this->nombre .' '. $this->apellido_paterno .' '. $this->apellido_materno;
    }

    public function cuentas()
    {
        return $this->hasMany('App\Cuenta' ,'cliente_id');
    }

    public function boletas()
    {
        return $this->hasMany('App\Boleta' ,'cliente_id');
    }
    public function monto_adeudado()
    {
        $monto_total=0;
        $montodb= DB::select('select SUM(total) as monto_total from boleta where estado_pago_id <> 3 and cliente_id = ?', [$this->id]);
        if($montodb>0){
            $monto_total=$montodb[0]->monto_total;
        }
        return $monto_total;
    }
}
