<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    //protected $connection = env('DB_SOFTLAND_CONNECTION');
    protected $table = 'MAP_cargo';
    protected $primaryKey = 'MAP_IdCargo';
    
    public function area(){
        return $this->belongsTo(Area::class, 'MAP_A_IdArea', 'MAP_IdArea');
    }
}