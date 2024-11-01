<?php

namespace App\Services;

use Google_Client;
use App\Helpers\BaseQuery;
use Google_Service_Sheets;
use App\Models\CoachService;
use App\Models\CoachGooglesheet;
use App\Models\ServiceGooglesheet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use App\Jobs\ImportCoaches;

class synchronization
{
    protected $BaseQuery;

    protected $_request;

    protected  $spreadsheetId = '16GP46laLDNXehK0doJn5PBpoINGj6N-nq268ZlWHAMM';

    public function __construct(BaseQuery $BaseQuery, CoachGooglesheet $CoachGooglesheet, ServiceGooglesheet $ServiceGooglesheet, Request $request)
    {
        $this->BaseQuery = $BaseQuery;
        $this->_request = $request;
    }

    private function getSheetData()
    {

        $client = new Google_Client();
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . storage_path('app/googlesheet/credentials.json'));
        $client->setAuthConfig(storage_path('app/googlesheet/credentials.json'));
        $client->setScopes(['https://www.googleapis.com/auth/spreadsheets']);

        // Initialize the Google Sheets Service
        $service = new Google_Service_Sheets($client);

        return $service;
    }


    public function services()
    {
        $service = $this->getSheetData();

        $range = 'Services!D2:ZZ9';

        try {
            // Fetch data from the specified range
            $response = $service->spreadsheets_values->get($this->spreadsheetId, $range);
            $values = $response->getValues();

            // Check if data is available
            if (empty($values)) {
                return response()->json([
                    'message' => 'No data found in the spreadsheet.',
                ], 404);
            }
            // dd($values[0]);
            // Loop through the values and save to the database
            foreach ($values[0] as $index => $service_name) {
                ServiceGooglesheet::updateOrCreate(
                    // Condition to check for existing record with all fields
                    [
                        'service_name' => $service_name,
                        'display_order' => $values[1][$index],
                        'subscriber_level' => $values[2][$index],
                        'service_type' => $values[3][$index],
                        'service_price' => $values[4][$index],
                        'service_description' => $values[5][$index],
                        // 'service_image' => $values[6][$index],
                        'service_bio' => $values[7][$index],
                    ],
                    // If no record found with all fields matching, create a new one or update if found
                    [
                        'display_order' => $values[1][$index] ?? null,
                        'subscriber_level' => $values[2][$index] ?? null,
                        'service_type' => $values[3][$index] ?? null,
                        'service_price' => $values[4][$index] ?? null,
                        'service_description' => $values[5][$index] ?? null,
                        'service_image' => $values[6][$index] ?? null,
                        'service_bio' => $values[7][$index] ?? null,
                        // Add more fields if needed
                    ]
                );
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

    public function coaches()
    {
        ImportCoaches::dispatch();

        return response()->json([
            'message' => 'Import started successfully, it will run in the background.',
        ], 200);

        // $coaches = $this->getSheetData();


        // $range = 'Coach!A5:AN';
   

        // try {
        //     // Fetch data from the specified range
        //     $response = $coaches->spreadsheets_values->get($this->spreadsheetId, $range);
        //     $values = $response->getValues();


        //     // Check if data is available
        //     if (empty($values)) {
        //         return response()->json([
        //             'message' => 'No data found in the spreadsheet.',
        //         ], 404);
        //     }
        //     // dd($values[0]);
        //     // Loop through the values and save to the database
        //     foreach ($values as $index => $values) {
        //         CoachGooglesheet::updateOrCreate(
        //             // Condition to check for an existing record by full_name
        //             ['email' => $values[24] ?? null],

        //             // All fields to update if record already exists, or create if it doesn't
        //             [
        //                 'full_name' => $values[0] ?? null,
        //                 'specialties' => $values[1] ?? null,
        //                 'category' => $values[2] ?? null,
        //                 'bio' => $values[3] ?? null,
        //                 'location' => $values[4] ?? null,
        //                 'fx' => $values[5] ?? null,
        //                 'pay' => $values[6] ?? null,
        //                 'how_good' => $values[7] ?? null,
        //                 'responsive' => $values[8] ?? null,
        //                 'on_whatsapp' => $values[9] ?? null,
        //                 'linkedin_url' => $values[23] ?? null,
        //                 'email' => $values[24] ?? null,
        //                 'email2' => $values[25] ?? null,
        //                 'whatsapp' => $values[26] ?? null,
        //                 'facetime_imessage' => $values[27] ?? null,
        //                 'terms_confirmed' => $values[28] ?? null,
        //                 'payment_details' => $values[29] ?? null,
        //                 'zelle_paypal_venmo' => $values[30] ?? null,
        //                 'sort_code' => $values[31] ?? null,
        //                 'account_number' => $values[32] ?? null,
        //                 'account_holder' => $values[33] ?? null,
        //                 'name_alias' => $values[34] ?? null,
        //                 'bio_alias' => $values[35] ?? null,
        //                 'job_offers' => $values[36] ?? null,
        //                 'photo_ai' => $values[37] ?? null,
        //                 'resume' => $values[38] ?? null,
        //                 'availability' => $values[39] ?? null,
        //             ]
        //         );
        //     }

        //     // call for updating coach services 
        //     $this->CoachServices();

        //     return response()->json([
        //         'message' => 'Data imported successfully.',
        //     ], 200);
        // } catch (\Exception $e) {
        //     return response()->json([
        //         'message' => 'Failed to fetch data from Google Sheets.',
        //         'error' => $e->getMessage(),
        //     ], 500);
        // }
    }


    // public function CoachServices()
    // {

    //     $range = 'Coach!A1:ZZ'; // Adjust this range as needed

    //     try {

    //         $service = $this->getSheetData();

    //         // Fetch the sheet data directly
    //         $response = $service->spreadsheets_values->get($this->spreadsheetId, $range);
    //         $coachSheetData = $response->getValues();

    //         // Check if data exists
    //         if (empty($coachSheetData)) {
    //             return response()->json([
    //                 'message' => 'No data found in the spreadsheet.',
    //             ], 404);
    //         }

    //         // Extract header and slice data rows from row 5 onwards
    //         $coachHeader = array_shift($coachSheetData); // Extract header row
    //         $coachDataFromRow5 = array_slice($coachSheetData, 3); // Start from row 5

    //         // Map database columns based on header
    //         $headerMapping = ServiceGooglesheet::pluck('service_name', 'service_name')->toArray();

    //         // Keep track of active coach-service pairs from the spreadsheet
    //         $activeCoachServices = [];

    //         foreach ($coachDataFromRow5 as $key => $row) {
    //             foreach ($coachHeader as $colIndex => $originalHeader) {
    //                 $originalHeader = trim($originalHeader);

    //                 // Check if header exists in the mapping
    //                 if (array_key_exists($originalHeader, $headerMapping)) {
    //                     $dbColumn = $headerMapping[$originalHeader];

    //                     // Retrieve service ID based on the mapped column
    //                     $serviceId = ServiceGooglesheet::where('service_name', $dbColumn)->value('id');

    //                     if ($serviceId === null) {
    //                         return response()->json([
    //                             'message' => "Service ID not found for {$dbColumn}."
    //                         ], 404);
    //                     }

    //                     $coachId = $key + 1;

    //                     // Check if the cell has data; if it does, sync it; if not, delete it
    //                     if (!empty($row[$colIndex])) {
    //                         // Add to active list
    //                         $activeCoachServices[] = [
    //                             'coach_id' => $coachId,
    //                             'service_id' => (int) $serviceId,
    //                         ];

    //                         // Use updateOrCreate to sync data
    //                         CoachService::updateOrCreate(
    //                             [
    //                                 'coach_id' => $coachId,
    //                                 'service_id' => (int) $serviceId,
    //                             ]
    //                         );
    //                     } else {
    //                         // If empty, delete the existing record
    //                         CoachService::where([
    //                             'coach_id' => $coachId,
    //                             'service_id' => (int) $serviceId,
    //                         ])->delete();
    //                     }
    //                 }
    //             }
    //         }

    //         return response()->json([
    //             'message' => 'Data imported, synced, and unused records deleted successfully.',
    //         ], 200);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'message' => 'Failed to fetch data from Google Sheets.',
    //             'error' => $e->getMessage(),
    //         ], 500);
    //     }
    // }
}
