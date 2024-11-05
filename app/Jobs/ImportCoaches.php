<?php

namespace App\Jobs;

use Log;
use Google_Client;
use Google_Service_Sheets;
use App\Models\CoachService;
use Illuminate\Bus\Queueable;
use App\Models\ServiceGooglesheet;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\CoachGooglesheet; // Adjust based on your model location

class ImportCoaches implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    // protected $spreadsheetId;
    protected  $spreadsheetId = '16GP46laLDNXehK0doJn5PBpoINGj6N-nq268ZlWHAMM';

    public function __construct()
    {
        // $this->spreadsheetId = $spreadsheetId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $coaches = $this->getSheetData();
        $range = 'Coach!A5:AN';
    
        try {
            // Fetch data from the specified range
            $response = $coaches->spreadsheets_values->get($this->spreadsheetId, $range);
            $values = $response->getValues();
    
            // Check if data is available
            if (empty($values)) {
                Log::info('No data found in the spreadsheet.');
                return;
            }
    
            // Loop through the values and save to the database
            foreach ($values as $index => $row) {
                CoachGooglesheet::updateOrCreate(
                    // Condition to check for an existing record by email
                    ['email' => $row[24] ?? null],
                    // All fields to update if record already exists, or create if it doesn't
                    [
                        'full_name' => $row[0] ?? null,
                        'specialties' => $row[1] ?? null,
                        'category' => $row[2] ?? null,
                        'bio' => $row[3] ?? null,
                        'location' => $row[4] ?? null,
                        'fx' => $row[5] ?? null,
                        'pay' => $row[6] ?? null,
                        'how_good' => $row[7] ?? null,
                        'responsive' => $row[8] ?? null,
                        'on_whatsapp' => $row[9] ?? null,
                        'linkedin_url' => $row[23] ?? null,
                        'email' => $row[24] ?? null,
                        'email2' => $row[25] ?? null,
                        'whatsapp' => $row[26] ?? null,
                        'facetime_imessage' => $row[27] ?? null,
                        'terms_confirmed' => $row[28] ?? null,
                        'payment_details' => $row[29] ?? null,
                        'zelle_paypal_venmo' => $row[30] ?? null,
                        'sort_code' => $row[31] ?? null,
                        'account_number' => $row[32] ?? null,
                        'account_holder' => $row[33] ?? null,
                        'name_alias' => $row[34] ?? null,
                        'bio_alias' => $row[35] ?? null,
                        'job_offers' => $row[36] ?? null,
                        'photo_ai' => $row[37] ?? null,
                        'resume' => $row[38] ?? null,
                        'availability' => $row[39] ?? null,
                    ]
                );
            }
    
            // Call for updating coach services
            $this->CoachServices();
    
            \Log::info('Data imported successfully.');
    
        } catch (\Exception $e) {
            \Log::error('Failed to fetch data from Google Sheets: ' . $e->getMessage());
        }
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


    public function CoachServices()
    {

        $range = 'Coach!A1:ZZ'; // Adjust this range as needed

        try {

            $service = $this->getSheetData();

            // Fetch the sheet data directly
            $response = $service->spreadsheets_values->get($this->spreadsheetId, $range);
            $coachSheetData = $response->getValues();

            // Check if data exists
            if (empty($coachSheetData)) {
                return response()->json([
                    'message' => 'No data found in the spreadsheet.',
                ], 404);
            }

            // Extract header and slice data rows from row 5 onwards
            $coachHeader = array_shift($coachSheetData); // Extract header row
            $coachDataFromRow5 = array_slice($coachSheetData, 3); // Start from row 5

            // Map database columns based on header
            $headerMapping = ServiceGooglesheet::pluck('service_name', 'service_name')->toArray();

            // Keep track of active coach-service pairs from the spreadsheet
            $activeCoachServices = [];

            foreach ($coachDataFromRow5 as $key => $row) {
                foreach ($coachHeader as $colIndex => $originalHeader) {
                    $originalHeader = trim($originalHeader);

                    // Check if header exists in the mapping
                    if (array_key_exists($originalHeader, $headerMapping)) {
                        $dbColumn = $headerMapping[$originalHeader];

                        // Retrieve service ID based on the mapped column
                        $serviceId = ServiceGooglesheet::where('service_name', $dbColumn)->value('id');

                        if ($serviceId === null) {
                            return response()->json([
                                'message' => "Service ID not found for {$dbColumn}."
                            ], 404);
                        }

                        $coachId = $key + 1;

                        // Check if the cell has data; if it does, sync it; if not, delete it
                        if (!empty($row[$colIndex])) {
                            // Add to active list
                            $activeCoachServices[] = [
                                'coach_id' => $coachId,
                                'service_id' => (int) $serviceId,
                            ];

                            // Use updateOrCreate to sync data
                            CoachService::updateOrCreate(
                                [
                                    'coach_id' => $coachId,
                                    'service_id' => (int) $serviceId,
                                ]
                            );
                        } else {
                            // If empty, delete the existing record
                            CoachService::where([
                                'coach_id' => $coachId,
                                'service_id' => (int) $serviceId,
                            ])->delete();
                        }
                    }
                }
            }

            return response()->json([
                'message' => 'Data imported, synced, and unused records deleted successfully.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch data from Google Sheets.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
