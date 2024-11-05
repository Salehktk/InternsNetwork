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

    }
}
