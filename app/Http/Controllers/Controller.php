<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;



//     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
//     <script>
//    $(document).ready(function() {
//     $('#searchInput').on('keyup', function() {
//         var query = $(this).val();
//         $.ajax({
//             url: "{{ route('CoachServices.show') }}",
//             method: 'GET',
//             data: { search: query },
//             dataType: 'json',
//             success: function(response) {
//                 console.log(response); 
//                 $('#servicesContainer').html(response.html);
//             }
//         });
//     });
// });



// public function CoachServices()
// {
//     $sheetId = '16GP46laLDNXehK0doJn5PBpoINGj6N-nq268ZlWHAMM';  
//     $sheetName = 'Services';  
//     $googlesheet3 = Sheets::spreadsheet($sheetId)->sheet($sheetName)->get(); 
  

//     $services = collect($googlesheet3)->slice(1, 7)->forget(2);

//     // Remove the element at index 2 from each item
//     $services = $services->map(function ($item) {
//         unset($item[2]);
//         return $item;
//     });

//     // Convert to array
//     $serviceData = $services->toArray();
    
//     // Transpose rows to columns
//     $transposedData = array_map(null, ...$serviceData);
 
//     $mergedData = collect($transposedData);

//     // Ensure unique items based on the first element of each item
//     $uniqueItems = $mergedData->unique(function ($item) {
//         return $item[0];
//     });

//     // Remove the first two items from the uniqueItems collection
//     $uniqueItems = $uniqueItems->slice(2);
//     // Reset keys to start from 0
//     $uniqueItems = $uniqueItems->values();

//     if ($search = request()->get('search')) {
//         $uniqueItems = $uniqueItems->filter(function ($item) use ($search) {
//             return stripos($item[0], $search) !== false || stripos($item[1], $search) !== false;
//         });
//     }

//     $totalItems = $uniqueItems->count();

//     // Output the result to verify
//     //dd($uniqueItems);

//     $perPage = 10;
//     $currentPage = request()->get('page', 1);

//     $startingIndex = ($currentPage - 1) * $perPage;

//     $itemsForCurrentPage = $uniqueItems->slice($startingIndex, $perPage)->values();

//     // Create a new paginator manually
//     $uniquePaginator = new LengthAwarePaginator(
//         $itemsForCurrentPage->all(), 
//         $totalItems, 
//         $perPage, 
//         $currentPage, 
//         ['path' => LengthAwarePaginator::resolveCurrentPath()]
//     );
//     if ($this->request->ajax()) {
       
//         $html = view('partials.services', compact('uniquePaginator'))->render();
//         return response()->json(['html' => $html]);
//     }
//     //dd($uniquePaginator);

//     return view('coach-services.view-services', compact('services', 'uniquePaginator')); 

// }


////harison function
// public function harrisonupdate(Request $request)
// {
//     $client = new GoogleClient();
//     $client->setAuthConfig(storage_path('app/credentials.json'));
//     $client->setScopes('https://www.googleapis.com/auth/spreadsheets');

//     $service = new GoogleSheets($client);
//     $spreadsheetId = '1vX4KDKmGJE3Knyki9xAhGCSOY-fiz6LZL4SAJaMbzNE';
//     $sheetName = 'Sheet1';

//     // Retrieve all data from the sheet
//     $response = $service->spreadsheets_values->get($spreadsheetId, $sheetName);
//     $data = $response->getValues(); // This returns an array of rows

//     // Get the request parameter
//     $reqName = $request->input('reqName');

//     // Find the row index
//     $rowIndex = null;
//     foreach ($data as $index => $item) {
//         if (isset($item[0]) && stripos($item[0], $reqName) !== false) {
//             $rowIndex = $index + 2; // +2 because Google Sheets API is 1-based and we have a header row
//             break;
//         }
//     }

//     if ($rowIndex === null) {
//         return response()->json(['error' => 'Name not found'], 404);
//     }

//     // Prepare the data to be updated as a multi-dimensional array
//     $updateData = [
//         [
//             $request->input('FullName'),
//             $request->input('Location'),
//             $request->input('Bio'),
//             $request->input('WhatsApp'),
//             $request->input('FaceTime'),
//             $request->input('LinkedInURL'),
//             $request->input('Email'),
//             $request->input('Email2'),
//             $request->input('JobOffers'),
//             $request->input('Availability'),
//             $request->input('NameAlias'),
//             $request->input('BioAlias'),
//             $request->input('TermsConfirm'),
//             $request->input('PhotoAI'),
//             $request->input('Advice'),
//             $request->input('AdviceCredentials'),
//         ]
//     ];

//     // Update the data in the sheet
//     $range = $sheetName . '!A' . $rowIndex . ':Z' . $rowIndex; // Adjust based on columns

//     $body = new ValueRange([
//         'values' => $updateData
//     ]);

//     $params = [
//         'valueInputOption' => 'RAW' // or 'USER_ENTERED'
//     ];

//     try {
//         $result = $service->spreadsheets_values->update($spreadsheetId, $range, $body, $params);
//         return response()->json($result);
//     } catch (\Exception $e) {
//         return response()->json(['error' => $e->getMessage()], 500);
//     }
// }


// okay for test sheet only
// $updateData = [
//     [
//         $request->input('FullName'),
//         $request->input('Location'),
//         $request->input('Bio'),
//         $request->input('WhatsApp'),
//         $request->input('FaceTime'),
//         $request->input('LinkedInURL'),
//         $request->input('Email'),
//         $request->input('Email2'),
//         $request->input('JobOffers'),
//         '',  ////resume
//         '' ,  ///AvailabilityNotes
//         // $request->input('Availability'),
//         $request->input('NameAlias'),
//         $request->input('Specialty'),
//         $request->input('Category'),
//         $request->input('BioAlias'),
//         $request->input('PayRate'),
//         $request->input('HowGood'),
//         $request->input('Responsiveness'),
//         $request->input('TermsConfirm'),
//         $request->input('Availability'),
//         // $request->input('PhotoAI'),
//         '',
//         '',
//         '', //AdviceCredentials
//         // $request->input('AdviceCredentials'),
//         $request->input('PaymentDetails'),
//     ]
// ];



 // Your AJAX call for filter
//  function fetchServices(query) {
//     $('#loader').show();
//     // const query = $('#searchInput').val();
   
//     $.ajax({
//         url: "{{ route('CoachServices.show') }}",
//         method: 'GET',
//         data: {
//             search: query,                  
//         },
//         dataType: 'json',
//         success: function(response) {
//             $('#servicesContainer').html(response.html);
//         },
//         error: function() {
//             // Handle error if needed
//             $('#servicesContainer').html('<p>Error fetching data. Please try again.</p>');
//         },
//         complete: function() {
//             // Hide the loader
//             $('#loader').hide();
//         }

//     });
// }

// // Bind keyup event with debounce
// $('#subscriberLevelFilter,#serviceTypeFilter,#servicePriceFilter').on('change', debounce(function() {
//     var query = $(this).val();
//     console.log(query);
    
//     fetchServices(query);

// }, 1000));

////////forrrr coach-services
// foreach ($allservices as $index => $serviceName) {
//     $serviceStatus = in_array($serviceName, $reqservices) ? 'Y' : '';
//     $updateData[] = $serviceStatus;
// }
// // dd($updateData);
// $range = 'A' . $rowIndex . ':HI' . $rowIndex;

// try {
//     $response = $sheet->range($range)->update([
//         'values' => [$updateData]
//     ]);



// $serviceHeaders = array_slice($data[0], 40, 174); // Headers from AO (index 40) to HI (index 217)
// $serviceUpdate = array_fill(0, count($serviceHeaders), ''); // Initialize with empty values

// foreach ($request->input('services', []) as $service) {
//     $serviceIndex = array_search($service, $serviceHeaders);
//     if ($serviceIndex !== false) {
//         $serviceUpdate[$serviceIndex] = 'Y'; // Mark matched service with 'Y'
//     }
// }

// // Merge service update into the main update data
// $updateData[0] = array_merge($updateData[0], $serviceUpdate);

// // Ensure we do not exceed the number of columns in Google Sheets
// $updateData[0] = array_slice($updateData[0], 0, 218); // Max 218 columns (A to HI)


}