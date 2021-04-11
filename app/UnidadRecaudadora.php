<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnidadRecaudadora extends Model
{
    //protected $connection = 'dbsanjudas';
    protected $table = 'unidad_recaudadora';
    protected $primaryKey = 'IdUnidadRecaudadora';
    

    // Relaciones

    public function banco(){
        return $this->belongsTo(Banco::class, 'B_IdBanco');
    }

    public function comuna(){
        return $this->belongsTo(Comuna::class, 'C_IdComuna', 'IdComuna');
    }

    public function diocesis(){
        return $this->belongsTo(Diocesis::class,'D_IdDiocesis','IdDiocesis');
    }

    public function zona(){
        return $this->belongsTo(Zona::class,'Z_IdZona','IdZona');
    }

    public function decanato(){
        return   $this->belongsTo(Decanato::class, 'D_IdDecanato','IdDecanato');
    }

    public function tipounidadrecaudadora(){
        return $this->belongsTo(TipoUnidadRecaudadora::class,'TUR_IdTipoUnidaRecaudadora','IdTipoUnidaRecaudadora');
    }

    public function aporte(){
        return $this->hasMany(Aporte::class, 'UR_IdUnidadRecaudadora', 'IdUnidadRecaudadora');
    }

    public function compromisopago(){
        return $this->hasMany(CompromisoPago::class, 'UR_IdUnidadRecaudadora', 'IdUnidadRecaudadora');
    }

    public function boleta(){
        return $this->hasMany(Boleta::class, 'UR_IdUnidadRecaudadora', 'IdUnidadRecaudadora')->take(1);
    }

}
