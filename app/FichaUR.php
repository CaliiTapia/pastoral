<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FichaUR extends Model
{
    protected $table = 'MAP_fichaur';
    protected $primaryKey = 'MAP_IdFichaUr';
    public $timestamps = false;

    public function ficha(){
        return $this->belongsTo(Ficha::class, 'IdFicha');
    }

    public function instituciones(){
        return $this->hasMany('App\Institucion', 'INCodigo', 'MAP_I_INCodigo');
    }

}
