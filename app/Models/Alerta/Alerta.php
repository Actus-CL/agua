<?php

namespace App\Models\Alerta;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

class Alerta extends Model
{
    protected $table = 'alerta';

   // protected $dates = [ 'created_at'];

    public function alerta_tipo()
    {
        return $this->belongsTo('App\Models\Alerta\AlertaTipo' ,'alerta_id');
    }

    public function alerta_entrega_correo()
    {
        return $this->hasMany('App\Models\Alerta\AlertaEntregaCorreo' );
    }

    public function alerta_entrega_sistema ()
    {
        return $this->hasMany('App\Models\Alerta\AlertaEntregaSistema' );
    }

    public function fechaForHumans ()
    {
        Carbon::setLocale('es');

        $carbon = new  Carbon();
        $date1= $carbon->now();
        $date2 =   $this->created_at;
        $dif= $date1->diffForHumans($date2,true,false,2);
    dd($dif);
        return $dif;
    }
}
