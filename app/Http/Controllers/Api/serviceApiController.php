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
            dd($user);
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


     public function allServices()
    {

        // dd('here');
        $allServices = AllService::with(['allservice.serviceBelongtopivot'])
        ->select('id', 'name_of_service', 'service')
        ->get();
    
        $allServiceNames = $allServices->flatMap(function ($service) {
        return $service->allservice->map(function ($item) {
            return optional($item->serviceBelongtopivot)->service_name;
        });
        })->unique(); 

 
            $valuesArray = $allServices->flatMap(function ($service) {
            return $service->allservice->map(function ($item) {
                return $item->value;
            });
            
        });
        // dd( $allServiceNames, $valuesArray );

        return response()->json([
        'status' => 'success',
        'services' => $allServiceNames->values()->toArray(), 
        'values' => $valuesArray->toArray(), 
     ], 200);
    }

}
