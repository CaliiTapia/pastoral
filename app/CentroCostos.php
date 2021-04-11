<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CentroCostos extends Model
{
    protected $table = 'CP_ccostos';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
