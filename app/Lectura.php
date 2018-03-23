<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lectura extends Model
{
    protected $table = 'lectura';

    public function periodo()
    {
        return $this->belongsTo('App\Periodo' );
    }
}
