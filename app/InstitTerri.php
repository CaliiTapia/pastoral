<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InstitTerri extends Model
{
    //
    protected $table = 'instit_terri';
    protected $primaryKey = 'ITINCodigo';
    protected $fillable = ['ITLatitud', 'ITLongitud'];
}
