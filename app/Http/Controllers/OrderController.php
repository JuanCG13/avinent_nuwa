<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Status;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        Order::create($request->validate([
          'first_name' => ['required', 'max:50'],
          'last_name' => ['required', 'max:50'],
          'email' => ['required', 'max:50', 'email'],
        ]));

        return to_route('dashboard');
    }
}


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