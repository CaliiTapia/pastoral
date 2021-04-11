<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModelRole extends Model
{
    //
    protected $table='model_has_roles';
    protected $primarykey='role_id';
   
}
