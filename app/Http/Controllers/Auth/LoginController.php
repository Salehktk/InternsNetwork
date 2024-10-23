<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect($this->redirectTo());
        }

        return view('auth.login'); 
    }

    protected function authenticated($request, $user)
    {
        return redirect($this->redirectTo());
    }

    protected function redirectTo()
    {
        $user = Auth::user();

        // Log the roles of the user
        // dd('Current user roles: ', $user->getRoleNames()->toArray());

        if ($user->hasRole('superadmin')) {
            return 'superadmin/service/show';
        } elseif ($user->hasRole('user')) {
            return route('users.dashboard'); 
        }

        return '/';  
    }
}
