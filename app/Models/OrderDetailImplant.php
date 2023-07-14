<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetailImplant extends Model
{
    use HasFactory;

    protected $table = 'tLiniesImplants';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'idComanda',
        'idLiniaCmd',
        'posicio',
        'idMarca',
        'idConexio',
        'idAngulacions',
        'analeg',
        'tipusAnaleg',
        'enviarCargol',
        'baseTi',
        'tipusBaseTi',
        'tallables',
        'alcadaGH'
    ];

   
    
}
