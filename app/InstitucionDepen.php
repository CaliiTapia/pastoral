<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InstitucionDepen extends Model
{
    protected $table = 'instit_depen';

    public function info(){
        return $this->hasOne(Institucion::class, 'INCodigo','IDINCodigo');
    }    
}
