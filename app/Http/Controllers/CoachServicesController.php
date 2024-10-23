<?php

namespace App\Http\Controllers;

use PDO;
use Cart;

use Google_Client;
use App\Models\User;
use Google_Service_Sheets;
use App\Models\BillingInfo;
use Illuminate\Http\Request;
use App\Mail\ServicePurchased;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Google_Service_Sheets_ValueRange;
use Revolution\Google\Sheets\Facades\Sheets;
use Illuminate\Pagination\LengthAwarePaginator;
use Stripe\Stripe;
use Stripe\Checkout\Session;



class CoachServicesController extends Controller
{
    private $request = null;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    public function index()
    { 

        $sheetId = '16GP46laLDNXehK0doJn5PBpoINGj6N-nq268ZlWHAMM';  
        $sheetName = 'Services';  
        $googlesheet3 = Sheets::spreadsheet($sheetId)->sheet($sheetName)->get(); 
      

        $services = collect($googlesheet3)->slice(1, 7)->forget(2);
        // dd($services);

        $services = $services->map(function ($item) {
            unset($item[2]);
            return $item;
        });


        $serviceData = $services->toArray();
        $transposedData = array_map(null, ...$serviceData);
        $mergedData = collect($transposedData);
        $uniqueItems = $mergedData->unique(function ($item) {
            return $item[0];
        });
        // dd($uniqueItems);

        $uniqueItemsWithId = $uniqueItems->map(function ($item, $index) {

            return array_merge(['id' => $index], $item);
        });

        $uniqueItems = $uniqueItemsWithId->slice(2);
        $uniqueItems = $uniqueItems->values();
 
        $subscriberLevels = $uniqueItems->pluck(1)->unique();
        $serviceTypes = $uniqueItems->pluck(2)->unique();
        $servicePrices = $uniqueItems->pluck(3)->unique();


        if ($search = request()->get('search')) {
            $uniqueItems = $uniqueItems->filter(function ($item) use ($search) {
                return stripos($item[0], $search) !== false || stripos($item[1], $search) !== false;
            });
        }


          // Apply additional filters
        $subscriberLevelFilter = request()->get('subscriber_level');
        $serviceTypeFilter = request()->get('service_type');
        $servicePriceFilter = request()->get('service_price');

        if ($subscriberLevelFilter) {
            $uniqueItems = $uniqueItems->filter(function ($item) use ($subscriberLevelFilter) {
                return $item[1] === $subscriberLevelFilter;
            });
        }

        if ($serviceTypeFilter) {
            $uniqueItems = $uniqueItems->filter(function ($item) use ($serviceTypeFilter) {
                return $item[2] === $serviceTypeFilter;
            });
        }


        $servicePriceFilter = trim(request()->get('service_price'));

        if ($servicePriceFilter === '') {
            $servicePriceFilter = 60;
        }
        
        // Apply price filter
        $uniqueItems = $uniqueItems->filter(function ($item) use ($servicePriceFilter) {
            return (int) $item[3] === (int) $servicePriceFilter;
        });

            $totalItems = $uniqueItems->count();

    

        $perPage = 12;
        $currentPage = request()->get('page', 1);

        $startingIndex = ($currentPage - 1) * $perPage;

        $itemsForCurrentPage = $uniqueItems->slice($startingIndex, $perPage)->values();


        // Create a new paginator manually
        $uniquePaginator = new LengthAwarePaginator(
            $itemsForCurrentPage->all(), 
            $totalItems, 
            $perPage, 
            $currentPage, 
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );
        if ($this->request->ajax()) {
           
            $html = view('partials.services', compact('uniquePaginator'))->render();
            return response()->json(['html' => $html]);
        }
        // dd($uniquePaginator);

        return view('coach-services.view-services', compact('services', 'uniquePaginator', 'subscriberLevels', 'serviceTypes', 'servicePrices')); 


    }

    public function CoachServices()
    {
        $sheetId = '16GP46laLDNXehK0doJn5PBpoINGj6N-nq268ZlWHAMM';  
        $sheetName = 'Services';  
        $googlesheet3 = Sheets::spreadsheet($sheetId)->sheet($sheetName)->get(); 
      

        $services = collect($googlesheet3)->slice(1, 7)->forget(2);

        $services = $services->map(function ($item) {
            unset($item[2]);
            return $item;
        });

 
        $serviceData = $services->toArray();
   
        $transposedData = array_map(null, ...$serviceData);
     
        $mergedData = collect($transposedData);
        $uniqueItems = $mergedData->unique(function ($item) {
            return $item[0];
        });

        $uniqueItemsWithId = $uniqueItems->map(function ($item, $index) {
            return array_merge(['id' => $index], $item);
        });

        $uniqueItems = $uniqueItemsWithId->slice(2);

        $uniqueItems = $uniqueItems->values();
        // dd($uniqueItems);

        $subscriberLevels = $uniqueItems->pluck(1)->unique();
        $serviceTypes = $uniqueItems->pluck(2)->unique();
        $servicePrices = $uniqueItems->pluck(3)->unique();
            // dd($servicePrices);

        if ($search = request()->get('search')) {
            $uniqueItems = $uniqueItems->filter(function ($item) use ($search) {
                return stripos($item[0], $search) !== false || stripos($item[1], $search) !== false;
            });
        }


          // Apply additional filters
        $subscriberLevelFilter = request()->get('subscriber_level');
        $serviceTypeFilter = request()->get('service_type');
        $servicePriceFilter = request()->get('service_price');

        if ($subscriberLevelFilter) {
            $uniqueItems = $uniqueItems->filter(function ($item) use ($subscriberLevelFilter) {
                return $item[1] === $subscriberLevelFilter;
            });
        }

        if ($serviceTypeFilter) {
            $uniqueItems = $uniqueItems->filter(function ($item) use ($serviceTypeFilter) {
                return $item[2] === $serviceTypeFilter;
            });
        }

    
        $servicePriceFilter = trim(request()->get('service_price'));

        if ($servicePriceFilter === '') {
            $servicePriceFilter = 60;
        }
        
        $uniqueItems = $uniqueItems->filter(function ($item) use ($servicePriceFilter) {
            return (int) $item[3] === (int) $servicePriceFilter;
        });

            $totalItems = $uniqueItems->count();

    

        $perPage = 12;
        $currentPage = request()->get('page', 1);

        $startingIndex = ($currentPage - 1) * $perPage;

        $itemsForCurrentPage = $uniqueItems->slice($startingIndex, $perPage)->values();


        $uniquePaginator = new LengthAwarePaginator(
            $itemsForCurrentPage->all(), 
            $totalItems, 
            $perPage, 
            $currentPage, 
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );
        if ($this->request->ajax()) {
           
            $html = view('partials.services', compact('uniquePaginator'))->render();
            return response()->json(['html' => $html]);
        }
        // dd($uniquePaginator);

        return view('coach-services.view-services', compact('services', 'uniquePaginator', 'subscriberLevels', 'serviceTypes', 'servicePrices')); 

    }


    public function SingleService($ServiceId)
    {
        $sheetId = '16GP46laLDNXehK0doJn5PBpoINGj6N-nq268ZlWHAMM';  
        $sheetName = 'Services';  
        $googlesheet3 = Sheets::spreadsheet($sheetId)->sheet($sheetName)->get(); 
    
        $services = collect($googlesheet3)->slice(1, 7)->forget(2);
        $services = $services->map(function ($item) {
            unset($item[2]);
            return $item;
        });
    
        $serviceData = $services->toArray();
        $transposedData = array_map(null, ...$serviceData);
        $mergedData = collect($transposedData);
    
        $uniqueItemsWithId = $mergedData->map(function ($item, $index) {
            return array_merge(['id' => $index], $item);
        }); 
        $service = $uniqueItemsWithId->firstWhere('id', $ServiceId);
       
        if (!$service) {
            abort(404, 'Service not found');
        }
    
        // Pass the service details to the view
        return view('coach-services.single-service', compact('service'));
    }




    public function addToCart(Request $request)
    {
        $sessionKey = auth()->check() ? auth()->id() : 'guest_' . request()->ip();

        Cart::session($sessionKey);
    

        $validated = $request->validate([
            'serviceId' => 'required|integer',
            'servicePrice' => 'required|numeric',
            'serviceName' => 'required|string',
        ]);
 
        $serviceId = $request->input('serviceId');
        $servicePrice = $request->input('servicePrice');
        $serviceName = $request->input('serviceName', '');
    
        // Add item to cart
        try {
            Cart::session($sessionKey)->add([
                'id' => $serviceId,
                'name' => $serviceName,
                'price' => $servicePrice,
                'quantity' => 1,
                'attributes' => [],
            ]);
    
            return response()->json([
                'message' => 'Service added to cart successfully!',
                'cartCount' => Cart::session($sessionKey)->getTotalQuantity(),
                'cartTotal' => Cart::session($sessionKey)->getTotal()
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function viewCart()
{ 
    $sessionKey = auth()->check() ? auth()->id() : 'guest_' . request()->ip();
    Cart::session($sessionKey);

    $cartItems = Cart::session($sessionKey)->getContent();
    $cartTotal = Cart::session($sessionKey)->getTotal();
    $cartCount = Cart::session($sessionKey)->getTotalQuantity();
    return view('coach-services.cart', compact('cartItems', 'cartTotal', 'cartCount'));
}


public function getCartCount()
{
    $sessionKey = auth()->check() ? auth()->id() : 'guest_' . request()->ip();
    $cartCount = Cart::session($sessionKey)->getTotalQuantity();
    return response()->json(['count' => $cartCount]);
}




public function removeCart(Request $request)
{
    $request->validate([
        'id' => 'required|integer',
    ]);

    $id = $request->input('id');

    $sessionKey = auth()->check() ? auth()->id() : 'guest_' . request()->ip();
    Cart::session($sessionKey)->remove($id);
    return redirect()->route('view-cart')->with('success', 'Cart item removed successfully.');
}


    //////checkout 


    public function showCheckoutForm(Request $request)
    {
        $sessionKey = auth()->check() ? auth()->id() : 'guest_' . request()->ip();
        $cartItems = Cart::session($sessionKey)->getContent();
        $cartTotal = Cart::session($sessionKey)->getTotal();

        $user = auth()->user(); 

        return view('coach-services.checkout', compact('cartItems', 'cartTotal', 'user'));
    }

    public function processCheckout(Request $request)
    {
        

        // Validate the incoming request data
        $validatedData = $request->validate([
            'email' => 'required|email',
            'name' => 'required|string',
            // 'last_name' => 'required|string',
            'phone' => 'required|string',
            'user_id' => 'nullable|integer|exists:users,id',
        ]);
    
        $sessionKey = auth()->check() ? auth()->id() : 'guest_' . request()->ip();
        $cartItems = Cart::session($sessionKey)->getContent();
        $serviceNames = $cartItems->pluck('name')->toArray();
    
        $userId = $request->input('user_id'); 

        $user = BillingInfo::updateOrCreate(
            [
                'user_id' => $userId,
                'email' => $validatedData['email'],
                'name' => $validatedData['name'],
                // 'last_name' => $validatedData['last_name'],
                'phone' => $validatedData['phone'],
                'services' => implode(', ', $serviceNames),
            ]
        );
    
        
        $createdAt = $user->created_at->format('Y-m-d H:i:s');
    
         try {
        $amount = 10000; // Amount in cents (for $100)
        $paymentIntent = $this->createStripePaymentIntent($amount, $validatedData['email'], $validatedData['name'], $validatedData['phone'], $serviceNames);
        $clientSecret = $paymentIntent->client_secret;

        $sheetsSuccess = $this->appendToGoogleSheet($validatedData, $serviceNames, $createdAt);
        
        // If payment succeeds
        if ($paymentIntent) {
            // Redirect to success page, passing necessary data
            Cart::session($sessionKey)->clear();
            session([
                'validatedData' => $validatedData,
                'serviceNames' => $serviceNames,
                'clientSecret' => $clientSecret,
            ]);

            return view('coach-services.checkout-confirmation', [
                            'clientSecret' => $clientSecret,
                            'validatedData' => $validatedData,
                            'serviceNames' => $serviceNames,
                            'sheetsSuccess' => $sheetsSuccess,
                        ])->with('success', 'Order placed successfully!');
        }
    } catch (\Exception $e) {
        \Log::error('Error in processCheckout: ' . $e->getMessage());
        return redirect()->back()->with('error', 'There was an error processing your payment.');
    }


    
    }
    
public function showThankYouPage(Request $request)
{
    $clientSecret = session('clientSecret');
    $validatedData =  session('validatedData'); // Retrieve and decode validated data
    $serviceNames = session('serviceNames');
    $paymentIntentId = $request->input('payment_id');

    if ( $validatedData && $serviceNames) {
        // Send email in the background, only if payment is successful
        $this->sendThankYouEmail($validatedData, $paymentIntentId, $serviceNames);

        session()->forget(['clientSecret', 'validatedData', 'serviceNames']);


        return view('coach-services.checkout-success', compact('validatedData', 'serviceNames', 'paymentIntentId'));
    } else {
        return redirect()->route('home')->with('error', 'Invalid payment session.');
    }
}

    
    protected function appendToGoogleSheet($validatedData, $serviceNames, $createdAt)
{
    $client = new Google_Client();
    $client->setAuthConfig(storage_path('app/credentials.json'));
    $client->setScopes('https://www.googleapis.com/auth/spreadsheets');

    $service = new Google_Service_Sheets($client);
    $spreadsheetId = '1o6bcyGibIT1ZVp1xvEQ_rdBJjxzlylDq-bSzlnhYNaA';
    $sheetName = 'Sheet1';
    $range = "{$sheetName}!A:F";

    $values = [
        [
            // $validatedData['first_name'],
            $validatedData['name'],
            $validatedData['email'],
            $validatedData['phone'],
            implode(', ', $serviceNames),
            $createdAt,
        ],
    ];

    $body = new Google_Service_Sheets_ValueRange([
        'values' => $values,
    ]);

    $params = [
        'valueInputOption' => 'RAW',
    ];

    $result = $service->spreadsheets_values->append($spreadsheetId, $range, $body, $params);

    return $result->getUpdates()->getUpdatedRows() > 0;
}

    protected function createStripePaymentIntent($amount, $email, $name, $phone,  $serviceNames)
{

    \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

    return \Stripe\PaymentIntent::create([
        'amount' => $amount, // Amount in cents
        'currency' => 'usd',
        'description' => 'Purchase of services',
        'metadata' => [
            'email' => $email,
            'name' => $name,
            'phone' => $phone,
            'services' => implode(', ', $serviceNames),
        ],
    ]);


    
}



protected function sendThankYouEmail($validatedData, $paymentIntentId, $serviceNames)
{
    $emailData = [
        'email' => $validatedData['email'],
        'name' => $validatedData['name'],
        'services' => implode(', ', $serviceNames),
        'payment_id' => $paymentIntentId,
    ];

    $recipent = "imussadiqayaz@gmail.com";
    //         // Send success email here, if required
    //         Mail::to($recipent)->send(new ServicePurchased ($user));


    // Send the email asynchronously or directly
    Mail::to($recipent)->send(new ServicePurchased($emailData));
}



}