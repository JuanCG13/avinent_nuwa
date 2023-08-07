<?php

namespace App\Http\Controllers;
use App\Models\User;
use Inertia\Inertia;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function activateUser(Request $request) {
        
        $user = User::find($request['id']);
        $user->idClientX3 = strtoupper($request['idClientX3']);
        $user->estat = 1;
        $user->save();
       
        $users = User::where('estat','=','0')->get();

        return back()->with('users', $users);
        

    }
}
