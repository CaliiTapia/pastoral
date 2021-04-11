<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Referencia extends Model
{
    protected $table = 'MAP_referencia';
    protected $primaryKey = 'MAP_IdReferencia';

    protected $hidden = ['created_at', 'updated_at'];

    public function participacion(){
        return $this->belongsTo(Participacion::class, 'MAP_P_IdParticipacion', 'MAP_IdParticipacion');
    } 
}
