<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Exception;
use App\Models\User;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\GoogleProvider;
use GeneaLabs\LaravelSocialiter\Facades\Socialiter;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Hash;





class GoogleAuthController extends Controller
{


    public function test(){

        $token =  'test1122';
        $externalUrl = "https://interns.network/login/?token=" . $token;

    // Redirect the user to the external URL
    return redirect()->away($externalUrl);

    }

    public function googleRedirect()
    {

        $config = [
            'client_id' => config('services.google.client_id'),
            'client_secret' => config('services.google.client_secret'),
            'redirect' => config('services.google.redirect'),
        ];

        // Build provider with web credentials
        return Socialite::buildProvider(GoogleProvider::class, $config)
            ->stateless()
            ->redirect();

    }

    public function  googleCallback()
    {
        // Set Web Google credentials
        $config = [
            'client_id' => config('services.google.client_id'),
            'client_secret' => config('services.google.client_secret'),
            'redirect' => config('services.google.redirect'),
        ];

        // Get user from web callback
        $googleUser = Socialite::buildProvider(GoogleProvider::class, $config)
            ->stateless()
            ->user();

        //  $googleUser = Socialite::driver('google')->stateless()->user();
        $user = User::where('email', $googleUser->email)->first();
        if (!$user) {
            $user = User::create(['name' => $googleUser->name, 'google_id' => $googleUser->id, 'email' => $googleUser->email, 'password' => \Hash::make(rand(100000, 999999))]);
        }

        Auth::login($user);

        return true;
        // return  redirect()->Route('home');
    }



    public function redirectToFacebook()
    {
        // Use the web configuration for Facebook
        $config = [
            'client_id' => config('services.facebook.client_id'),
            'client_secret' => config('services.facebook.client_secret'),
            'redirect' => config('services.facebook.redirect'),
        ];

        // Redirect to Facebook using the web configuration
        return Socialite::buildProvider(\Laravel\Socialite\Two\FacebookProvider::class, $config)
            ->stateless()
            ->redirect();
    }

public function redirectToFacebookApi()
{
    // Use the API configuration for Facebook
    $config = [
        'client_id' => config('services.facebook-api.client_id'),
        'client_secret' => config('services.facebook-api.client_secret'),
        'redirect' => config('services.facebook-api.redirect'),
    ];

     try {

         return Socialite::buildProvider(\Laravel\Socialite\Two\FacebookProvider::class, $config)
            ->stateless()
            ->redirect();
    } catch (\Exception $e) {

        // $this->redirectToAppLogin($e);
           $customUrlScheme = "https://interns.network/universal-link/login";
        // dd(redirect()->To($customUrlScheme));
        return redirect()->away($customUrlScheme);
    }

}


public function handleFacebookCallback()
{
    try {
        // Use the web credentials configuration
        $config = [
            'client_id' => config('services.facebook.client_id'),
            'client_secret' => config('services.facebook.client_secret'),
            'redirect' => config('services.facebook.redirect'),
        ];

 
        // Get the Facebook user information
        $fbUser = Socialite::buildProvider(\Laravel\Socialite\Two\FacebookProvider::class, $config)
            ->stateless() // Use stateless if you're not using sessions, even for web
            ->user();

        // Find or create user based on Facebook data
        $user = User::where('facebook_id', $fbUser->id)
                    ->orWhere('email', $fbUser->email)
                    ->first();

        if (!$user) {
            // If user doesn't exist, create a new one
            $user = User::create([
                'facebook_id' => $fbUser->id,
                'name' => $fbUser->name,
                'email' => $fbUser->email,
                'password' => bcrypt(Str::random(12)),
            ]);
        }

        // Log the user in
        Auth::login($user);

        // Redirect to the intended page after login
        return true;
        // return redirect()->intended('home');
        
    } catch (\Exception $e) {
        return redirect()->route('login')->with('error', 'There was an error logging in with Facebook.');
    }
}


public function handleFacebookCallbackApi()
{
    try {
        // Use the API credentials configuration
        $config = [
            'client_id' => config('services.facebook-api.client_id'),
            'client_secret' => config('services.facebook-api.client_secret'),
            'redirect' => config('services.facebook-api.redirect'),
        ];

        // Get the Facebook user information
        $fbUser = Socialite::buildProvider(\Laravel\Socialite\Two\FacebookProvider::class, $config)
            ->stateless() // Stateless for API
            ->user();

        // Find or create user based on Facebook data
        $user = User::where('facebook_id', $fbUser->id)
                    ->orWhere('email', $fbUser->email)
                    ->first();

        if (!$user) {
            // If user doesn't exist, create a new one
            $user = User::create([
                'facebook_id' => $fbUser->id,
                'name' => $fbUser->name,
                'email' => $fbUser->email,
                'password' => bcrypt(Str::random(12)),
            ]);
        }
       
      $customUrlScheme =   "https://interns.network/universal-link/home";
          
            return redirect()->away($customUrlScheme);

        

    } catch (\Exception $e) {

        // $this->redirectToAppLogin($e);
           $customUrlScheme = "https://interns.network/universal-link/login";
        // dd(redirect()->To($customUrlScheme));
        return redirect()->away($customUrlScheme);
    }
}



    public function googleRedirectapi()
    {  
        $config = [
            'client_id' => config('services.google_app.client_id'),
            'client_secret' => config('services.google_app.client_secret'),
            'redirect' => config('services.google_app.redirect'),
        ];

        try {

        return Socialite::buildProvider(GoogleProvider::class, $config)
            ->stateless()
            ->redirect();

    
       } catch (\Exception $e) {
        
        // $this->redirectToAppLogin($e);
           $customUrlScheme = "https://interns.network/universal-link/login";
        // dd(redirect()->To($customUrlScheme));
        return redirect()->away($customUrlScheme);
       }
    }

    public function  googleCallbackApi()
    {
        // Set App Google credentials
        $config = [
            'client_id' => config('services.google_app.client_id'),
            'client_secret' => config('services.google_app.client_secret'),
            'redirect' => config('services.google_app.redirect'),
        ];

      try {
            // Get the user from the callback (stateless)
            $googleUser = Socialite::buildProvider(GoogleProvider::class, $config)
                ->stateless()
                ->user();
    
    // dd($googleUser);
            // Check if the user already exists in the database
            $user = User::where('email', $googleUser->email)->first();

            if (!$user) {
                // If user doesn't exist, create a new user with Google details
                $user = User::create([
                    'name' => $googleUser->name,
                    'google_id' => $googleUser->id,
                    'email' => $googleUser->email,
                    'password' => Hash::make(rand(100000, 999999)), // Fixed Hash import issue
                ]);
            }

      
           $customUrlScheme =   "https://interns.network/universal-link/home";
            // Redirect the user to the external URL
            // dd(redirect()->To($customUrlScheme));
            return redirect()->away($customUrlScheme);

        } catch (\Exception $e) {

              $customUrlScheme = "https://interns.network/universal-link/login";
        // dd(redirect()->To($customUrlScheme));
        return redirect()->away($customUrlScheme);
           
        }
    }


  public function redirectToApple()
{
  
    try {
            return Socialite::driver('sign-in-with-apple')
            ->scopes(['email', 'name']) // Requesting email and name scopes
            ->redirect();
      
    } catch (\Exception $e) {
        
        // $this->redirectToAppLogin($e);
          $customUrlScheme = "https://interns.network/universal-link/login";
        // dd(redirect()->To($customUrlScheme));
        return redirect()->away($customUrlScheme);
       }
}


public function handleAppleCallback(Request $request)
{
    \Log::info('Apple callback request data: ', $request->all());
    
    try {
       
          \Log::info('Apple callback received.');
        // Dynamically generate the client_secret
        $clientSecret = $this->generateAppleClientSecret();
    
        $tokenUrl = 'https://appleid.apple.com/auth/token';

        // Prepare the payload
        $payload = [
            'client_id'     => env('SIGN_IN_WITH_APPLE_CLIENT_ID'),
            'client_secret' => $clientSecret,
            'code'          => $request->input('code'),  // Authorization code returned by Apple
            'grant_type'    => 'authorization_code',
            'redirect_uri'  => env('SIGN_IN_WITH_APPLE_REDIRECT'),
        ];
        // Send request to Apple to get the access token
        $response = Http::asForm()->post($tokenUrl, $payload);
        
        // Get the response data
        $appleData = $response->json();
        
        // Check if id_token exists
        if (!isset($appleData['id_token'])) {
            // Handle the absence of id_token gracefully
            return redirect()->route('login')->with('error', 'id_token not found in the response from Apple. Please check your configuration.');
        }

        // Decode the id_token to extract user information
        $jwtPayload = explode('.', $appleData['id_token'])[1];
        $jwtPayload = json_decode(base64_decode($jwtPayload), true);
    // dd($jwtPayload);
        // Extract user information from the decoded payload
        $appleId = $jwtPayload['sub'];  // Apple's unique user identifier
        $email = $jwtPayload['email'] ?? null;  // Email (optional depending on Apple's response)
       $name = $jwtPayload['name'] ?? 'Apple user';  // Name (if provided)
        // Find or create the user in the database
        $user = User::where('apple_id', $appleId)->first();

        if (!$user) {
            $user = new User();
            $user->apple_id = $appleId;
            $user->name = $name;  // You can change this to a real name if available
            $user->email = $email;
            $user->password = bcrypt(Str::random(12));  // Random password since Apple provides token-based login
            $user->save();
        }
        \Log::info('user generated: ' . $user);
       
        // $this->redirectToApp($user);
            $customUrlScheme =   "https://interns.network/universal-link/home";
    // Redirect the user to the external URL
    // dd(redirect()->To($customUrlScheme));
    return redirect()->away($customUrlScheme);
    
    } catch (\Exception $e) {
       $customUrlScheme = "https://interns.network/universal-link/login";
    // dd(redirect()->To($customUrlScheme));
      return redirect()->away($customUrlScheme);
    }
}





public function generateAppleClientSecret()
{
    $teamId = env('APPLE_TEAM_ID');
    $clientId = env('SIGN_IN_WITH_APPLE_CLIENT_ID');
    $keyId = env('APPLE_KEY_ID');

    // Load the private key from a .pem file
    $privateKey = file_get_contents(storage_path('apple-auth-key.pem'));

    $claims = [
        'iss' => $teamId,  // Team ID from Apple Developer
        'iat' => time(),
        'exp' => time() + 86400 * 180, // 6 months expiry
        'aud' => 'https://appleid.apple.com',
        'sub' => $clientId,  // Service ID from Apple Developer
    ];

    // Generate the JWT client_secret using the ES256 algorithm
    return \Firebase\JWT\JWT::encode($claims, $privateKey, 'ES256', $keyId);
}


// public function redirectToApp($user)
// {
//     // Assuming the user authentication is successful
//     $token = $user->createToken('authToken')->plainTextToken;

//     $customUrlScheme = "internsNetwork:///home?token=" . $token;

//     // dd($customUrlScheme);

//     // dd( redirect()->away($customUrlScheme));
    
// }


public function redirectToApp($user)
{
    // Generate the token for the authenticated user
    // $token = $user->createToken('authToken')->plainTextToken;

    // Build the external URL with the token
    // $externalUrl = "https://interns.network/login/?token=" . $token;
    //   $customUrlScheme = "internsNetwork:///home?token=" . $token;
       $customUrlScheme =   "https://interns.network/universal-link/home";
    // Redirect the user to the external URL
    // dd(redirect()->To($customUrlScheme));
    return redirect()->away($customUrlScheme);
}



public function redirectToAppLogin($e)
{
    //   $errorMessage = urlencode($e->getMessage()); // URL encode the message to ensure special characters are handled

    //   $customUrlScheme = "internsNetwork:///login?message=" . $errorMessage;
     
     $customUrlScheme = "https://interns.network/universal-link/login";
    // dd(redirect()->To($customUrlScheme));
      return redirect()->away($customUrlScheme);
    
}

 public function handleTest(Request $request)
    {
        // You can retrieve parameters here from the URL or request
        $param = $request->get('param', 'default_value');

        // Return a simple JSON response for testing
        return response()->json([
            'message' => 'Universal Link hit successfully!',
            'param' => $param
        ]);
    }
}
