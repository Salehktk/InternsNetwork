<?php

namespace App\Http\Controllers;

use App\Models\CoachGooglesheet;
use App\Models\ServiceGooglesheet;
class SheetCoachServiceController extends Controller
{
    /////////>>>>>>>>>>>for import googlesheet data.....>>>>>>>////////
    public function coachShow()
    {
        $selectedCoach = CoachGooglesheet::get();

        return view('superadmin.superadmin-coach', compact('selectedCoach'));
    }
    
    public function serviceShow()
    {
        $allService = ServiceGooglesheet::get();
        return view('superadmin.superadmin-service', compact('allService'));
    }

}
