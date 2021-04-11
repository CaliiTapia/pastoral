<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    //
    protected $table = 'MAP_area';
    protected $primaryKey = "MAP_IdArea";

    public function cargos(){
        return $this->belongsToMany(Cargo::class, 'MAP_area_cargo', 'MAP_A_IdArea', 'MAP_C_IdCargo');
    }

    // public function cargos(){
    //     return $this->hasMany(Cargo::class, 'MAP_A_IdArea', 'MAP_IdArea');
    // }
    
}

