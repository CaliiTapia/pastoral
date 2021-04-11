<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ficha extends Model
{
    protected $table = 'ficha';
    protected $primaryKey = 'IdFicha';

    //Relaciones
    public function fichaUR(){
        return $this->hasMany('App\FichaUR', 'MAP_F_IdFicha', 'IdFicha');
    }

    public function instituciones(){
        return $this->hasMany('App\Institucion', 'INCodigo', 'MAP_I_INCodigo');
    }

    public function zonas(){
        return $this->hasMany('App\Zona', 'IdZona');
    }

    public function scopeNumeroDocumento($query, $rut){
        if ($rut) {
            return $query->where('NumeroDocumento', 'LIKE', "%$rut%");
        }
    }

    public function scopeApellidoPaterno($query, $apepaterno){
        if ($apepaterno) {
            return $query->where('ApellidoPaterno', 'LIKE', "%$apepaterno%");
        }
    }

    public function scopeApellidoMaterno($query, $apematerno){
        if ($apematerno) {
            return $query->where('ApellidoMaterno', 'LIKE', "%$apematerno%");
        }
    }

    public function scopeIdZona($query, $zo){
        if ($zo) {
            return $query->where('zona.IdZona', 'LIKE', "%$zo%");
        }
    }

    public function scopeINCodigo($query, $in){
        if ($in) {
            return $query->where('institucion.INCodigo', 'LIKE', "%$in%");
        }
    }
}
