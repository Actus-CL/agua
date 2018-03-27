<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Periodo extends Model
{
    protected $table = 'periodo';


    public function boletas()
    {
        return $this->hasMany('App\Boleta' ,'boleta_id');
    }

    public function nombre_formato()
    {
        return substr($this->nombre,0,2) . "-" . substr($this->nombre,2,6);
    }


    public function consumo_cliente($cliente_id)
    {
        $monto_total=0;
        $montodb= DB::select('select SUM(total) as monto_total from boleta where estado_pago_id <> 3 and cliente_id = ? and periodo_id= ?', [$cliente_id,$this->id]);
        if($montodb[0]->monto_total>0){
            $monto_total=$montodb[0]->monto_total;
        }
        return $monto_total;
    }
}
