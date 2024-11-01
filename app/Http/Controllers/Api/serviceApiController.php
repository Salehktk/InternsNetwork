<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpWord\Shared\Validate;
use App\Models\AllService;
use App\Models\ServiceGooglesheet;
use App\Models\CoachGooglesheet;


class serviceApiController extends Controller
{
    
   public function login(Request $request)
    {
        // Validate request input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        $user = User::where('email', $request->email)->first();
    
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'The provided credentials are incorrect.'
            ], 401); 
        }
    
        $token = $user->createToken('Personal Access Token')->plainTextToken;
    
        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 200); 
    }

   


    public function createUser(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
    
        if ($validate->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $validate->errors()
            ], 422); 
        }
    
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
    
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->plainTextToken;
    
            return response()->json([
                'message' => 'User successfully registered',
                'token' => $token,
                'user' => $user
            ], 201); 
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'User registration failed',
                'error' => $e->getMessage(),
            ], 500); 
        }
    }
    


    public function logout(Request $request)
    {
        try {
         
            $user = $request->user();
            // dd($user);
            if ($user) {
              
                $user->tokens()->delete();
    
                return response()->json([
                    'message' => 'Successfully logged out',
                ], 200);
            }
    
            return response()->json([
                'message' => 'No authenticated user found',
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Logout failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    ////-----all services------///////


     public function allServices(Request $request)
    {
        $allService = ServiceGooglesheet::get();

        return response()->json([
        'status' => 'success',
        'services' => $allService, 
        
     ], 200);
    }

    public function singleServiceShow($id)
{
    $singleService = ServiceGooglesheet::find($id);
    
    if ($singleService) {
        return response()->json([
            'status' => 'success',
            'service' => $singleService,
        ], 200);
    } else {
        return response()->json([
            'status' => 'error',
            'message' => 'Service not found.',
        ], 404);
    }
}



     public function allCoaches(Request $request)
    {
        $allCoaches = CoachGooglesheet::get();
        
        return response()->json([
        'status' => 'success',
        'coaches' => $allCoaches, 
        
     ], 200);
    }

  public function singleCoachShow($id){

     $singleCoach = CoachGooglesheet::find($id);
    
    if ($singleCoach) {

        return response()->json([
            'status' => 'success',
            'coach' => $singleCoach,
        ], 200);

    } else {

        return response()->json([
            'status' => 'error',
            'message' => 'Coach not found.',
        ], 404);
        
    }
 }
}
