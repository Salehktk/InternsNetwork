<?php

namespace App\Http\Controllers;

use App\Models\AllService;
use App\Models\CoachService;

use Illuminate\Http\Request;
use App\Models\ServicePivote;
use App\Models\CoachGooglesheet;
use App\Models\ServiceGooglesheet;
use Revolution\Google\Sheets\Facades\Sheets;
use Google_Client;
use Google_Service_Sheets;

class SheetCoachServiceController extends Controller
{
    /////////>>>>>>>>>>>for import googlesheet data.....>>>>>>>////////

    public function importCoachsheet()
    {

        $client = new Google_Client();
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . storage_path('app/googlesheet/credentials.json'));
        $client->setAuthConfig(storage_path('app/googlesheet/credentials.json'));
        $client->setScopes(['https://www.googleapis.com/auth/spreadsheets']);
    
        // Initialize the Google Sheets Service
        $service = new Google_Service_Sheets($client);
    
        // Define the Spreadsheet ID and Range
        $spreadsheetId = '16GP46laLDNXehK0doJn5PBpoINGj6N-nq268ZlWHAMM';
        $range = 'Services!D2:GC9';
    
        try {
            // Fetch data from the specified range
            $response = $service->spreadsheets_values->get($spreadsheetId, $range);
            $values = $response->getValues();
    
            // Check if data is available
            if (empty($values)) {
                return response()->json([
                    'message' => 'No data found in the spreadsheet.',
                ], 404);
            }
    
            // Loop through the values and save to the database
            foreach ($values[0] as $index => $service_name) {
                ServiceGooglesheet::create([
                    'service_name' => $service_name,
                    'display_order' => $values[1][$index] ?? null,
                    'subscriber_level' => $values[2][$index] ?? null,
                    'service_type' => $values[3][$index] ?? null,
                    'service_price' => $values[4][$index] ?? null,
                    'service_description' => $values[5][$index] ?? null,
                    'service_image' => $values[6][$index] ?? null,
                    'service_bio' => $values[7][$index] ?? null,
                    // Add more fields if needed
                ]);
            }
    
            return response()->json([
                'message' => 'Data imported successfully.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch data from Google Sheets.',
                'error' => $e->getMessage(),
            ], 500);
        }











        $sheetId = '16GP46laLDNXehK0doJn5PBpoINGj6N-nq268ZlWHAMM';
        $sheetName = 'Coach';
        $coachSheet = Sheets::spreadsheet($sheetId)->sheet($sheetName)->get();
        $coachDataFromRow3 = array_slice($coachSheet->toArray(), 4);

        $coachHeader = $coachSheet->pull(0);

        $headerMapping = [
            'FullName' => 'full_name',
            'Specialties' => 'specialties',
            'Category' => 'category',
            'Bio' => 'bio',
            'Location' => 'location',
            'FX' => 'fx',
            'Pay' => 'pay',
            'How good? 1-3' => 'how_good',
            'Responsive? 1-3' => 'responsive',
            'On WhatsApp?' => 'on_whatsapp',
            'LinkedIn URL' => 'linkedin_url',
            'Email' => 'email',
            'Email2' => 'email2',
            'WhatsApp' => 'whatsapp',
            'FaceTime & iMessage' => 'facetime_imessage',
            'T&Cs Confirmed' => 'terms_confirmed',
            'Payment Details' => 'payment_details',
            'Zelle | PayPal | Venmo' => 'zelle_paypal_venmo',
            'Sort Code' => 'sort_code',
            'Account Number' => 'account_number',
            'Account Holder' => 'account_holder',
            'NameAlias' => 'name_alias',
            'BioAlias' => 'bio_alias',
            'JobOffers' => 'job_offers',
            'PhotoAI' => 'photo_ai',
            'Resume' => 'resume',
            'Availability' => 'availability',
        ];
        



        foreach ($coachDataFromRow3 as $key => $header) {

            $coachdata = new CoachGooglesheet();

            foreach ($coachHeader as $key2 => $OrignaleHeader) {

                $OrignaleHeader = trim($OrignaleHeader);

                if (array_key_exists($OrignaleHeader, $headerMapping) && isset($header[$key2])) {

                    $dbColumn = $headerMapping[$OrignaleHeader];

                    $coachdata->$dbColumn = $header[$key2];
                }
            }

            $coachdata->save();
        }

        return true;
    }



    // public function importServicesheet()
    // {
    //     $sheetId = '16GP46laLDNXehK0doJn5PBpoINGj6N-nq268ZlWHAMM';
    //     $sheetName = 'Coach';
    //     $coachSheet = Sheets::spreadsheet($sheetId)->sheet($sheetName)->get();
    //     $coachDataFromRow3 = array_slice($coachSheet->toArray(), 4);

    //     $coachHeader = $coachSheet->pull(0);

   

    //     $headerMapping = ServiceGooglesheet::pluck('service_name', 'service_name')->toArray();

    //     foreach ($coachDataFromRow3 as $key => $header) {
         
    //         foreach ($coachHeader as $key2 => $OrignaleHeader) {

    //             $OrignaleHeader = trim($OrignaleHeader);

    //             if (array_key_exists($OrignaleHeader, $headerMapping) && isset($header[$key2])) {

    //                 $dbColumn = $headerMapping[$OrignaleHeader];
    //                 if(!empty($header[$key2])){

    //                     $coachdata = new CoachService();

    //                     $coachdata->coach_id =  $key+1;
    //                     $serviceId = ServiceGooglesheet::where('service_name', $dbColumn)->pluck('id')->first();
    //                     $coachdata->service_id =  $serviceId;
    //                     $coachdata->save();

    //                 }
    //             }
    //         }

           
    //     }
        
    //     return true;
    // }


       
// public function importServicesheetDirectly()
// {
//     $client = new Google_Client();
//     putenv('GOOGLE_APPLICATION_CREDENTIALS=' . storage_path('app/googlesheet/credentials.json')); // Set environment variable
//     $client->setAuthConfig(storage_path('app/googlesheet/credentials.json')); // Path to credentials.json
//     // $client->setScopes(['https://www.googleapis.com/auth/spreadsheets.readonly']); // Set correct scopes
//    $client->setScopes(['https://www.googleapis.com/auth/spreadsheets']);
//     // dd($client);
//     // Initialize the Google Sheets Service
//     $service = new Google_Service_Sheets($client);

//     // Define the Spreadsheet ID and Range
//     $spreadsheetId = '16GP46laLDNXehK0doJn5PBpoINGj6N-nq268ZlWHAMM';
//     // $range = 'Services!D2:GC9';
//      $range = 'Services!D2:F9';

//     try {
//         // Fetch data from the specified range
//         $response = $service->spreadsheets_values->get($spreadsheetId, $range);
//         $values = $response->getValues();

//         dd($values);

//         foreach($values as $key1 => $singleValue){
//             dd($singleValue);
//              foreach($singleValue as $key2 => $single){
           
//              }

//         }
//         // Debugging output to check if data is being fetched
//         // dd($values);

//         // Check if data is available
//         // if (empty($values)) {
//         //     return response()->json([
//         //         'message' => 'No data found in the spreadsheet.',
//         //     ], 404);
//         // } else {
//         //     return response()->json([
//         //         'data' => $values,
//         //     ], 200);
//         // }
//     } catch (\Exception $e) {
//         // Handle errors
//         return response()->json([
//             'message' => 'Failed to fetch data from Google Sheets.',
//             'error' => $e->getMessage(),
//         ], 500);
//     }
// }

public function importServicesheet()
{
    $client = new Google_Client();
    putenv('GOOGLE_APPLICATION_CREDENTIALS=' . storage_path('app/googlesheet/credentials.json'));
    $client->setAuthConfig(storage_path('app/googlesheet/credentials.json'));
    $client->setScopes(['https://www.googleapis.com/auth/spreadsheets']);

    // Initialize the Google Sheets Service
    $service = new Google_Service_Sheets($client);

    // Define the Spreadsheet ID and Range
    $spreadsheetId = '16GP46laLDNXehK0doJn5PBpoINGj6N-nq268ZlWHAMM';
    $range = 'Services!D2:GC9';

    try {
        // Fetch data from the specified range
        $response = $service->spreadsheets_values->get($spreadsheetId, $range);
        $values = $response->getValues();

        // Check if data is available
        if (empty($values)) {
            return response()->json([
                'message' => 'No data found in the spreadsheet.',
            ], 404);
        }

        // Loop through the values and save to the database
        foreach ($values[0] as $index => $service_name) {
            ServiceGooglesheet::create([
                'service_name' => $service_name,
                'display_order' => $values[1][$index] ?? null,
                'subscriber_level' => $values[2][$index] ?? null,
                'service_type' => $values[3][$index] ?? null,
                'service_price' => $values[4][$index] ?? null,
                'service_description' => $values[5][$index] ?? null,
                'service_image' => $values[6][$index] ?? null,
                'service_bio' => $values[7][$index] ?? null,
                // Add more fields if needed
            ]);
        }

        return response()->json([
            'message' => 'Data imported successfully.',
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Failed to fetch data from Google Sheets.',
            'error' => $e->getMessage(),
        ], 500);
    }
}


    public function coachShow()
    {
        $selectedCoach = CoachGooglesheet::all();

        return view('superadmin.superadmin-coach', compact('selectedCoach'));
    }
    
    public function serviceShow()
    {
      
        $allServicespivot = ServicePivote::all();
        $allService = AllService::all();
        // dd( $allService);

        $service = AllService::with('allservice.serviceBelongtopivot')->first(); // Adjust according to your relationship


        return view('superadmin.superadmin-service', compact('allService','allServicespivot', 'service'));
    }

    public function AllserviceImport()
    {
          $sheetId = '16GP46laLDNXehK0doJn5PBpoINGj6N-nq268ZlWHAMM';

        $sheetName = 'Services';

        $AllServiceSheet = Sheets::spreadsheet($sheetId)->sheet($sheetName)->get();

        $coachHeader = $AllServiceSheet->pull(1);

        $coachDataFromRow3 = array_slice($AllServiceSheet->toArray(), 1, 7);

        // dd($coachDataFromRow3, $coachHeader);
        $headerMapping = [
            'Service' => 'service',
            'Name of service' => 'name_of_service',
        ];

        foreach($coachDataFromRow3 as $singleRecords)
        {
            $coachdata  = new AllService();
            // dd($coachdata);
            
            foreach($singleRecords as $key1 =>  $againSingle){

                foreach($coachHeader as $key2 => $singleHeader){

                    if (array_key_exists($singleHeader, $headerMapping) ) {

                        if($key1 ==  $key2){

                     
                            $dbColumn = $headerMapping[$singleHeader];

                         

                            $coachdata->$dbColumn = $againSingle;

                          }
                    }
                 
                }

            }

            $coachdata->save();

        }

        return true;
    }
    public function servicePiot()
    {
        $sheetId = '16GP46laLDNXehK0doJn5PBpoINGj6N-nq268ZlWHAMM';

        $sheetName = 'Services';

        $coachSheet = Sheets::spreadsheet($sheetId)->sheet($sheetName)->get();
        $coachDataFromRow31 = array_slice($coachSheet->toArray(), 2, 7);
        $coachDataFromRow3 = array_map(function($row) {
            return array_slice($row, 3);  
        }, $coachDataFromRow31);

        $coachHeader22 = $coachSheet->pull(1);

        $coachHeader = array_slice($coachHeader22, 3);
   
        $headerMapping = ServiceGooglesheet::pluck('service_name', 'service_name')->toArray();

        foreach ($coachDataFromRow3 as $key => $header) {

            foreach ($coachHeader as $key2 => $OrignaleHeader) {

                $OrignaleHeader = trim($OrignaleHeader);

                if (array_key_exists($OrignaleHeader, $headerMapping) && isset($header[$key2])) {

                    $dbColumn = $headerMapping[$OrignaleHeader];
                    if(!empty($header[$key2])){
                        $coachdata = new ServicePivote();
                        $coachdata->all_service_id =  $key+1;
                        $serviceId = ServiceGooglesheet::where('service_name', $dbColumn)->pluck('id')->first();
                        $coachdata->service_googlesheet_id =  $serviceId;
                        $coachdata->value =  $header[$key2];
                        $coachdata->save();

                    }
                    

                    // $coachdata->$dbColumn = $header[$key2];
                }
            }

           
        }
        
        return true;
    }
}
