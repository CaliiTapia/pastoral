<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComprobanteTipo extends Model
{
    protected $table = 'CP_cpbtetipo';
    protected $primaryKey = 'id';

    protected $fillable = [
        'INCodigo',
        'alias',
        'glosa',
        'cpbTip',
        'isActive',
    ];

    public function institucion()
    {
        return $this->hasOne('App\Institucion', 'INCodigo', 'INCodigo');
    }

    public function detalle()
    {
        return $this->hasMany('App\ComprobanteTipoDetalle', 'id_cpbte', 'id');
    }
}
