<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'tLiniesComanda';
    protected $primaryKey = 'idLiniaCmd';
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

    public function implants(): HasMany
    {
        return $this->hasMany(OrderDetailImplant::class,'idLiniaCmd', 'idLiniaCmd');
    }

    
}
