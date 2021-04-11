<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Comprobante extends Model
{
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->cpbCorr = self::generateCorr($model);
        });
    }

    protected $table = 'CP_cpbtes';
    protected $primaryKey = 'cpbNum';
    public $timestamps = false;
    protected $fillable = [
        'InsCod',
        'cpbAno',
        'cpbNum',
        'cpbFec',
        'cpbMes',
        'cpbEst',
        'cpbGlo',
        'cpbTip',
        'usuario',
        'cpbFecIn',
    ];

    protected $dates = [
        'cpbFec', 'cpbFecIn'
    ];

    protected $appends = ['formatted_cpbfec', 'total_debe', 'total_haber'];

    public function getFormattedCpbfecAttribute()
    {
        return (new Carbon($this->cpbFec))->format('d/m/Y');
    }

    public function getTotalDebeAttribute()
    {
        $total = 0;
        if (count($this->movimientos->toArray()) > 0) {
            $total = array_sum(array_map(function ($item) {
                return floor($item['movDebe']);
            }, $this->movimientos->toArray()));
        }
        return $total;
    }

    public function getTotalHaberAttribute()
    {
        $total = 0;
        if (count($this->movimientos->toArray()) > 0) {
            $total = array_sum(array_map(function ($item) {
                return floor($item['movHaber']);
            }, $this->movimientos->toArray()));
        }
        return $total;
    }

    public function movimientos()
    {
        return $this->hasMany('App\Movimientos', 'cpbNum', 'cpbNum');
    }

    public function periodo()
    {
        return $this->hasOne('App\Periodo', 'idPeriod', 'cpbAno');
    }

    public function institucion()
    {
        return $this->hasOne('App\Institucion', 'INCodigo', 'InsCod');
    }

    static function generateCorr($model)
    {
        $lastCorr = self::where('InsCod', $model->InsCod)->latest('cpbNum')->count();
        return ++$lastCorr;
    }
}
