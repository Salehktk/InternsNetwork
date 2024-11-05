<?php

namespace App\Http\Controllers;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }



     public function dashboard()
    {
        return view('users.dashboard');
    }

    public function AdminDashboard()
    {
        return view('superadmin.dashboard');
    }

   
}
