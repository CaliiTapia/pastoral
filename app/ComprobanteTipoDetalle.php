<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComprobanteTipoDetalle extends Model
{
    protected $table = 'CP_cpbtetipoDet';
    public $timestamps = false;

    protected $fillable = [
        'id_cpbte',
        'codCuenta',
        'setDebe',
        'setHaber',
    ];

    public function cuenta()
    {
        return $this->hasOne('App\Cuentas', 'pctCod', 'codCuenta');
    }
}
