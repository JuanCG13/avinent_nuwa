<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Status;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;


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
        if(Auth::user()->isAdmin) {
            $orders = Order::all();
            } else {
            $orders = Order::where('idUsuari','=',Auth::user()->id)->get();
           }
    
           $status = Status::all();
    
           return Inertia::render('Dashboard', [
           'orders' => $orders, 
           'status' => $status
            ]);
           
       
    }

    public function getOrders(Request $request)
    {
        if(Auth::user()->isAdmin) {
            $orders = Order::all();
            } else {
            $orders = Order::where('idUsuari','=',Auth::user()->id)
                        ->get();
           }
    
       return $orders;
    }

    public function editOrder(Request $request) {

        // if (!Auth::user()->isAdmin || !Auth::user()->id == Order::where('idComanda','=',$request->id)->get()->idUsuari) {
        //     return abort(403);
        // }
       // die(Order::where('idComanda','=',$request->id)->first()['idUsuari']);
        
       $_order = Order::where('idComanda','=',$request->id)
        ->first();

        if (!$_order) {
            return  abort(404);
        }

        $order['orderHeader'] = $_order;
    
        $orderWorks = Order::find($request->id)
        ->works;    

        $order['orderWorks'] = $orderWorks;

        foreach ($orderWorks as $work) {   
            $work['implantsDetail'] = OrderDetail::find($work['idLiniaCmd'])
            ->implants;   
        }

        $action = $request->orderAction == 'edit' ? 2 : 1;       
    
        return Inertia::render('Orders/Order', [
            'orderData' => $order, 
            'orderAction' => $action
            ]);
 
    }

    

}

