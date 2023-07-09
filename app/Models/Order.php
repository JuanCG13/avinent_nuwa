<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'tComandes';
    public $timestamps = false;
    
    protected $fillable = [
        'idComanda',
        'idComandaX3',
        'idEstat',
        'idUsuari',
        'idClientX3',
        'idAdrecaEnviament',
        'tipusEnviament',
        'refPacient',
        'persContacte',
        'telfContacte',
        'dataPrevista', 
        'dataCreacio',
        'dataModificacio',
    ];




}
