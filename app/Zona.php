<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zona extends Model
{
    protected $table = "zona";
    protected $primaryKey = "IdZona";

    public function decanato(){
        return $this->hasMany(Decanato::class, 'Z_IdZona', 'IdZona');
    }

    // Scopes
    public function scopeDiocesis($query, $codigo){
        return $query->where('D_IdDiocesis', Diocesis::where('Codigo', $codigo)->first()->IdDiocesis);
    }

    public function scopeSantiago($query){
        return $query->where('D_IdDiocesis', Diocesis::where('Codigo', '100000000000')->first()->IdDiocesis);
    }

    public function scopeCentro($query){
        return $query->where('Codigo', '100100000000')->first();
    }

    public function scopeCordillera($query){
        return $query->where('Codigo', '100200000000')->first();
    }

    public function scopeNorte($query){
        return $query->where('Codigo', '100300000000')->first();
    }

    public function scopeSur($query){
        return $query->where('Codigo', '100400000000')->first();
    }

    public function scopeOriente($query){
        return $query->where('Codigo', '100500000000')->first();
    }

    public function scopeOeste($query){
        return $query->where('Codigo', '100600000000')->first();
    }

    public function scopeMaipo($query){
        return $query->where('Codigo', '100700000000')->first();
    }

    public function scopeInstituciones($query){
        return $query->where('Codigo', '101000000000')->first();
    }

    public function scopeOficina($query){
        return $query->where('Codigo', '100800000000')->first();
    }

    public function institucion(){
        return $this->belongsTo(Institucion::class, 'INZona');
    }

    public static function Z(){
        return Zona::select('IdZona', 'Nombre')
                    ->orderBy('Nombre','ASC')
                    ->get();
    }
}
