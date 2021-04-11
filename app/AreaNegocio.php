<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AreaNegocio extends Model
{
    protected $table = 'CP_areaN';
    protected $primaryKey = 'areaCod';
    public $timestamps = false;
}
