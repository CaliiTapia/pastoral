<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participacion extends Model
{
    protected $table = 'MAP_participacion';
    protected $primaryKey = 'MAP_IdParticipacion';

    public function cargos(){
        return $this->hasMany('App\Cargo', 'MAP_IdCargo', 'MAP_C_IdCargo');
    }
    public function areas(){
        return $this->hasMany('App\Area', 'MAP_IdArea', 'MAP_A_IdArea');
    }
}
