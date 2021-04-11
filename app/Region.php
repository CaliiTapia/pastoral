<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    // protected $connection = 'dbsanjudas';
    protected $table = 'region';
    protected $primaryKey = 'IdRegion';

    public function comunas()
    {
                            /*ModeloFinal*//*ModeloIntermedio*//*MFKIntermedio*//*MFKFinal*//*MPKInicial*//*MPKIntermedio*/
        return $this->hasManyThrough('App\Comuna', 'App\Ciudad','R_IdRegion','C_IdCiudad','IdRegion','IdCiudad');
    }
}
