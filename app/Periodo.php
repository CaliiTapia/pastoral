<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    protected $table = 'CP_periodo';
    protected $primaryKey = 'idPeriod';
    public $timestamps = false;
}
