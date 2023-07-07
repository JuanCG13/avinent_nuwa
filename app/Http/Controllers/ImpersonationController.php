<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Inertia\Inertia;

class ImpersonationController extends Controller
    {
    
        public function impersonate(Request $request, User $user)
        {
            
            if (Auth::user()->canImpersonate()) {
                $impersionationuser = Auth::User();
                Auth::user()->impersonate($user);

                // return Inertia::render('dashboard', [
                //     'impersonationUser' => $impersionationuser, 
                // ]);
            }

   
            //return redirect()->route('welcome');

        }
    
        public function leaveImpersonate()
        {
            Auth::user()->leaveImpersonation();
            //return redirect()->route('dashboard');
        }
    }

