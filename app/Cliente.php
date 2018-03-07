<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'cliente';

    public function proyectos()
    {
        return $this->belongsToMany('App\proyecto' ,'cliente_proyecto');
    }

    public function nombreCompleto()
    {
        return $this->nombre .' '. $this->apellido_paterno .' '. $this->apellido_materno;
    }
}
