<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonaCargo extends Model
{
    //
    protected $table = 'personas_cargo';
    protected $primaryKey ='PCPECodigo';
    
    // Busqueda por institucion
    public function scopeInstitucion($query, $codigo){
        return $query->where('PCINCodigo', $codigo);
    }

    // Agregar datos personas
    public function personas(){
        return $this->hasMany(Persona::class, 'PECodigo', 'PCPECodigo');
    }
}
