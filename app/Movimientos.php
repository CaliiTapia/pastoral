<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Movimientos extends Model
{
    protected $table = 'CP_movim';
    public $timestamps = false;
    protected $fillable = [
        'cpbAno',
        'cpbNum',
        'movNum',
        'areaCod',
        'ctaCod',
        'cpbFec',
        'cpbMes',
        'ccCod',
        'cajCod',
        'movIfCant',
        'DetGCod',
        'movDetGCant',
        'codAux',
        'TipDocCb',
        'NumDocCb',
        'TipDocRef',
        'NumDocRef',
        'movDebe',
        'movHaber',
        'movGlosa',
        'monCod',
    ];

    protected $appends = ['formatted_cpbfec'];

    public function getFormattedCpbfecAttribute()
    {
        return (new Carbon($this->cpbFec))->format('d/m/Y');
    }

    public function cuenta()
    {
        return $this->hasOne('App\Cuentas', 'pctCod', 'ctaCod');
    }

    public function tipoDocumento()
    {
        return $this->hasOne('App\TipoDocumento', 'TipDoc', 'TipDocRef');
    }

    public function auxiliar()
    {
        return $this->hasOne('App\Auxiliar', 'codAux', 'codAux');
    }

    public function centroCosto()
    {
        return $this->hasOne('App\CentroCostos', 'id', 'ccCod');
    }

    public function areaNegocio()
    {
        return $this->hasOne('App\AreaNegocio', 'areaCod', 'areaCod');
    }

    public function comprobante()
    {
        return $this->belongsTo('App\Comprobante', 'cpbNum', 'cpbNum');
    }
}
