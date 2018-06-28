<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Proyecto extends Model
{
    protected $table = 'proyecto';
    public function clientes()
    {
        return $this->belongsToMany('App\Cliente' ,'cliente_proyecto');
    }
}
