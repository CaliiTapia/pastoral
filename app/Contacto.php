<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    /*protected $connection = 'dbsanjudas';*/
    protected $table = 'contacto';
    protected $primaryKey = 'IdContacto';

    /*Scope*/
    public function scopeJoinFicha($query){
        
        return $query->join('fichas','fichas.IdFichas','contacto.F_IdFichas')->join('cargo','cargo.IdCargo','fichas.C_IdCargo');
         
    }
}
