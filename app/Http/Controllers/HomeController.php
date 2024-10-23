<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\CochingSetup;
use Illuminate\Http\Request;
use App\Models\CoachFeedback;
use Revolution\Google\Sheets\Facades\Sheets;

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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // public function index()
    // {
    //     return view('admin.dashboard');
    // }

     public function dashboard()
    {
        return view('users.dashboard');
    }

   
}
