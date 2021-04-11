<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Institucion extends Model
{
    //
    protected $table = 'institucion';
    protected $primaryKey = 'INCodigo';
    protected $fillable = ['INTICodigo','INNombre', 'INNombre2', 'INRut','INFecCrea','INDireccion','INSector','INTelefono','INCelular','INCasilla','INEmail','INWeb'];

    //Scope
    public function scopeParroquia($query){
        return $query->where('INTICodigo', '007');
    }
    public function scopeCapilla($query){
        return $query->where('INTICodigo', '008');
    }

    public function  cargos(){
        return $this->hasMany(PersonaCargo::class, 'PCINCodigo', 'INCodigo');
    }

    public function fichaUR(){
        return $this->belongsTo(FichaUR::class, 'MAP_I_INCodigo');
    }
    public function zonas(){
        return $this->belongsTo(Zona::class, 'IdZona');
    }

    public static function parro($id){
        return Institucion::where('INZona', '=', $id)
                            ->where('INTICodigo', '=', 007)
                            ->orderBy('INNombre','ASC')
                            ->get();
    }
}
