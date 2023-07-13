<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Status;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    public function store(Request $request)
    {
        // Order::create($request->validate([
        //   'first_name' => ['required', 'max:50'],
        //   'last_name' => ['required', 'max:50'],
        //   'email' => ['required', 'max:50', 'email'],
        // ]));
        //  dd($request->orderHeader['refPacient']);
        $order = new Order();
        $order->idUsuari = $request->user()->id;
        $order->idEstat = 0;
        $order->idAdrecaEnviament = $request->orderHeader['idAdrecaEnviament'];
        $order->refPacient = $request->orderHeader['refPacient'];
        $order->persContacte = $request->orderHeader['persContacte'];
        $order->telfContacte = $request->orderHeader['telContacte'];
        $order->save();

       // return to_route('dashboard');
    }

    public function dashboard(Request $request)
    {
       $orders = Order::where('idUsuari','=',Auth::user()->id)->get();
       $status = Status::all();

       return Inertia::render('Dashboard', [
       'orders' => $orders, 
       'status' => $status
        ]);
       
    }

    public function getOrders(Request $request)
    {
       $orders = Order::where('idUsuari','=',Auth::user()->id)->get();
       return $orders;
    }
}

