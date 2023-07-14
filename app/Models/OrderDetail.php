<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'tLiniesComanda';
    public $timestamps = false;

    protected $fillable = [
        'idLiniaCmd',
        'idComanda',
        'idTipusArticle',
        'idMaterial',
        'idTipusArticle2',
        'quantitat',
        'numDesmontables',
        'posDesmontables',
        'idColor',
        'idIncisal',
        'idSistemaFitxer',
        'fitxer1',
        'fitxer2',
        'numDents',
        'numImplants',
        'acabatBrillant',
        'tractamentTermic',
        'anodizat',
        'zonesPulides',
        'colorAnodizat',
        'teMicrorosca',
        'numMicrorosques',
        'inclourePilars',
        'enviarModel',
        'tipusEnviament',
        'dataRecepcio',
        'idOFX3',
        'dataCreacio',
        'dataModificacio',
    ];

   
    
}
