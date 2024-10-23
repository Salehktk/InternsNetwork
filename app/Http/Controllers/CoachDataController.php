<?php

namespace App\Http\Controllers;

use Google\Exception;
use App\Models\CoachData;
use App\Models\AdminSetup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Revolution\Google\Sheets\Facades\Google;
use Revolution\Google\Sheets\Facades\Sheets;
use Google_Client;
use Google_Service_Sheets;
use Google_Service_Sheets_ValueRange;


class CoachDataController extends Controller
{

    public function index()
    {
        $sheet = Sheets::spreadsheet('1TPrcySEmefhYIdAYZTPoCh2EPnMSI79q6yfl7MF8Vn0')->sheet('CoachData')->get();

        $header = $sheet->pull(0);
        $data = $sheet->all();
        // dd($data, $header);
        if (count($data) >= 3) {
            $filteredData1 = array_slice($data, 0);
        } else {
            echo "Array doesn't have enough elements.";
        }
// dd($filteredData1);
        $values = Sheets::collection($header, $filteredData1)->toArray();
        
        $names = array_column($values, 'name');
      
        $biographies = array_column($values, 'biography');
    
        $nameBiographyMap = array_combine($names, $biographies);

      
        $coachBiographyMap = [];

        foreach ($values as $value) {
         
           
            $pdf_path = isset($value['pdf_path']) ? $value['pdf_path'] : '';
            $image_path = isset($value['image_path']) ? $value['image_path'] : '';
            
            $Email = isset($value['Email']) ? $value['Email'] : '';

            $coachdata[$value['Name']] = [
                'pdf_path' => $pdf_path,
                'image_path' => $image_path,
                'coachmail' => $Email
            ];
           
        }

       

        return view('coach.coachingdata', compact(['values', 'nameBiographyMap', 'coachdata', ]));
    }

    public function coachingdataStore(Request $request)
    {
            // dd($request->image_path);
        $selectedCoach = $request->input('Name');
        $existingPdfPath = $request->input('existing_pdf_path');
        $existingImagePath = $request->input('existing_image_path');

        if($request->pdf_path == null && $existingPdfPath == null){
            $request->validate([
                'pdf_path' => 'required|file|mimes:pdf',
            ]);
            // $pdfPath = $request->pdf_path;
            // $check = 1;
        }else{
            if($request->pdf_path){
                $request->validate([
                    'pdf_path' => 'required|file|mimes:pdf',
                ]);

                $pdfPath = $request->pdf_path;
                $check = 1;
            }else{
                $pdfPath = $existingPdfPath;
                $check = 0;
            }
        }








        if($request->image_path == null && $existingImagePath == null){
            $request->validate([
                'image_path' => 'required|image'
            ]);
            // $pdfPath = $request->pdf_path;
            // $check = 1;
        }else{
            if($request->image_path){
                $request->validate([
                     'image_path' => 'required|image'
                ]);

                $imagePath = $request->image_path;
                $checkImg = 1;
            }else{
                $imagePath = $existingImagePath;
                $checkImg = 0;
            }
        }









            
        $request->validate([
            'Name' => 'required',
            'coachmail' => 'required',
            // 'pdf_path' => 'nullable|file|mimes:pdf',
            // 'image_path' => 'nullable|image'
        ]);
    
        $adminsetup = AdminSetup::where('coachmail', $request->input('coachmail'))->first();
        if ($adminsetup) {
            // $pdfPath = $existingPdfPath;
            // $imagePath = $existingImagePath;
    
            if ($request->hasFile('pdf_path') && $check == 1) {
                $pdf = $request->file('pdf_path');
                $originalFileName = $pdf->getClientOriginalName();
                $pdfPath = 'pdfs/' . $originalFileName; 
                $pdf->move(public_path('pdfs'), $originalFileName); 
            }
    
            if ($request->hasFile('image_path') && $checkImg == 1) {
                $image = $request->file('image_path');
                $originalFileName = $image->getClientOriginalName();
                $imagePath = 'imag/' . $originalFileName; 
                $image->move(public_path('imag'), $originalFileName); 
            }
    

            if($check == 1 && $checkImg == 1){
                CoachData::updateOrCreate(
                    ['email' => $request->input('coachmail')],
                    [
                        'name' => $request->input('Name'),
                        'admin_setup_id' => $adminsetup->id,
                        'pdf_path' => $pdfPath,
                        'image_path' => $imagePath
                    ]
                );
                $pdfUrl = url($pdfPath);
                $imageUrl = url($imagePath);
            }elseif($check == 1 && $checkImg == 0){
                CoachData::updateOrCreate(
                    ['email' => $request->input('coachmail')],
                    [
                        'name' => $request->input('Name'),
                        'admin_setup_id' => $adminsetup->id,
                        'pdf_path' => $pdfPath,
                    ]
                );
                $pdfUrl = url($pdfPath);
                $imageUrl = $existingImagePath;
            }elseif($check == 0 && $checkImg == 1){
            CoachData::updateOrCreate(
                ['email' => $request->input('coachmail')],
                [
                    'name' => $request->input('Name'),
                    'admin_setup_id' => $adminsetup->id,
                    'image_path' => $imagePath
                ]
            );
                $pdfUrl = $existingPdfPath;
                $imageUrl = url($imagePath);
        }else{
                CoachData::updateOrCreate(
                    ['email' => $request->input('coachmail')],
                    [
                        'name' => $request->input('Name'),
                        'admin_setup_id' => $adminsetup->id,
                    ]
                );
                $pdfUrl = $existingPdfPath;
                $imageUrl = $existingImagePath;
            }
           
    
            // $pdfUrl = url($pdfPath);
            // $imageUrl = url($imagePath);
    
            $this->updateGoogleSheet($request->input('coachmail'), $pdfUrl, $imageUrl);
    
            return redirect()->route('coachingdata')->with('success', 'Data Added Successfully');
        } else {
            return redirect('/coaching/data')->with('error', 'Matching Coach email not found');
        }         
    }



    private function updateGoogleSheet($email, $pdfUrl, $imageUrl)
    {

        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/credentials.json'));
        $client->setScopes('https://www.googleapis.com/auth/spreadsheets');
    
        $service = new Google_Service_Sheets($client);    
        $spreadsheetId = '1TPrcySEmefhYIdAYZTPoCh2EPnMSI79q6yfl7MF8Vn0';
        $sheetName = 'CoachData';
 
        $sheetData = $service->spreadsheets_values->get($spreadsheetId, $sheetName)->getValues();
   
        $rowIndex = null;
    

        foreach ($sheetData as $index => $row) {
            if (isset($row[1]) && $row[1] === $email) { 

            
                // Email is the second column (index 1)

                $rowIndex = $index + 1; 
                break;
            }
        }
    
        if ($rowIndex === null) {
            Log::error('Email not found in the sheet.');
            return;
        }
    
        $range = "$sheetName!D$rowIndex:E$rowIndex"; 
        
        $values = [
            [$pdfUrl, $imageUrl]
        ];
       
    
        $body = new Google_Service_Sheets_ValueRange([
            'values' => $values
        ]);
    
        $params = [
            'valueInputOption' => 'RAW'
        ];
    
        try {
            $result = $service->spreadsheets_values->update($spreadsheetId, $range, $body, $params);
            Log::info('Data updated successfully:', (array) $result);
        } catch (Exception $e) {
            Log::error('Error updating data in Google Sheet: ' . $e->getMessage());
        }
    }
    




}