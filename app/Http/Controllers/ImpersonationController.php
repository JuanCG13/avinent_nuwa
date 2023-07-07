<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ImpersonationController extends Controller
    {
    
        public function impersonate(Request $request, User $user)
        {
            Auth::user()->impersonate($user);
            //return redirect()->intended('dashboard');
        }
    
        public function leaveImpersonate()
        {
            Auth::user()->leaveImpersonation();
            //return redirect()->route('dashboard');
        }
    }

