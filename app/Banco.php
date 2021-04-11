<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
    //Configuracion inicial
    //protected $connection = 'dbsanjudas';
    protected $table = 'banco';
    protected $primaryKey = 'IdBanco';
}
