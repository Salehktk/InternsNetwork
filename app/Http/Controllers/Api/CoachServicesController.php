<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CoachServices;


class CoachServicesController extends Controller
{
    protected $coachService;

    public function __construct(CoachServices $coachService)
    {
        $this->coachService = $coachService;
    }

    public function index(Request $request){
       
        // $user = $this->coachService->index();

        

        // return response()->json([
        //     'message' => 'Welcome to the dashboard!',
        //     'user' => $user,
        // ]);
        $user = $request->user();

       

        if ($user) {
            return response()->json([
                'success' => true,
                'user' => $user,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'User not found',
        ], 404);
    }

}
