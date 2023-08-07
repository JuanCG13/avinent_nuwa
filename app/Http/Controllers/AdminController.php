<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Status;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function dashboard() {
        $users = User::where('estat','=','0')->get();
        $orders = Order::all();
        $status = Status::all();

        return Inertia::render('Admin/Dashboard', [
        'users' => $users, 
        'orders' => $orders, 
        'status' => $status
    ]);
    }
}
