<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $table = 'tComandes';
    protected $primaryKey = 'idComanda';
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


    public function works(): HasMany
    {
        return $this->hasMany(OrderDetail::class,'idComanda', 'idComanda');
    }


}
