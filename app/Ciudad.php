<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    /*protected $connection = 'dbsanjudas';*/
    protected $table = 'ciudad';
    protected $primaryKey = 'IdCiudad';

    public function comunas()
    {
        return $this->hasMany('App\Comuna', 'C_IdCiudad', 'IdComuna');
    }
}
