<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cuentas extends Model
{
    protected $table = 'CP_pctas';
    public $timestamps = false;
    protected $fillable = [
        'pctCod',
        'pctNivel',
        'pctNombre',
        'pctTipo',
        'pctCcos',
        'pctAux',
        'pctDoc',
        'pctEDoc',
        'pctConb',
        'pctMonAd',
        'pctDetG',
        'pctPptoCaja',
        'pctInFin',
        'pctDetLi',
    ];
}
