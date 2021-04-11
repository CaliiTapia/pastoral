<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InstitObser extends Model
{
    //
    protected $table = 'instit_obser';
    protected $primaryKey ='IBINCodigo';
    protected $fillable = ['IBINCodigo','IBObserv'];
}
