<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParticipacionParroquial extends Model
{
    //
    protected $table = 'MAP_participacion';
    protected $primaryKey = 'MAP_IdParticipacion';

    // Relaciones
    public function zona(){
        return $this->belongsTo(Zona::class, 'MAP_Z_IdZona', 'IdZona');
    }

    public function institucion(){
        return $this->belongsTo(Institucion::class, 'MAP_I_INCodigo', 'INCodigo');
    }
    public function capilla(){
        return $this->belongsTo(Institucion::class, 'MAP_I_INCodigoCapilla', 'INCodigo');
    }
    public function cargo(){
        return $this->belongsTo(Cargo::class, 'MAP_C_IdCargo', 'MAP_IdCargo');
    }
    public function ficha(){
        return $this->belongsTo(Ficha::class, 'MAP_F_IdFicha', 'IdFicha');
    }

    public function referencias(){
        return $this->hasMany(Referencia::class, 'MAP_P_IdParticipacion', 'MAP_IdParticipacion');
    }
    
    public function area(){
        return $this->belongsTo(Area::class , 'MAP_A_IdArea', 'MAP_IdArea');
    }
    
}
