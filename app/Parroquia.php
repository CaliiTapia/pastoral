<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parroquia extends Model
{
    //
    protected $connection = 'dbsanjudas';
    protected $table='parroquia';
    protected $primarykey='IdParroquia';
      
}