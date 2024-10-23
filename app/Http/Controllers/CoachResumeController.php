<?php

namespace App\Http\Controllers;


use OpenAI;
use Google_Client;
use App\Models\Chat;
use Google\Exception;
use GuzzleHttp\Client;
use App\Models\PromptMsg;
use Google_Service_Sheets;
use App\Models\DataInSheet;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\Mail;
// use Revolution\Google\Sheets\Sheets;
use Google_Service_Sheets_ValueRange;
use Illuminate\Support\Facades\Storage;
use Revolution\Google\Sheets\Facades\Sheets;
use Smalot\PdfParser\Parser; // PDF parsing library
use Illuminate\Support\Facades\View;

class CoachResumeController extends Controller
{


    public function showUploadForm()
    {
        
        $promptrecord = PromptMsg::first();
        $promptMsg = $promptrecord->prompt_msg;
        // dd($promptMsg);

        //  $promptMsg ='This GPT generates a coach alias based on the user\'s resume and optionally, their LinkedIn profile. It analyzes the four most recent work experiences and creates a biography in a specified format, highlighting business areas, expertise, and personal interests. It then generates a unique alias name and a realistic professional headshot for a 24-year-old person that matches the identified gender. The headshot should be professional, realistic, and approachable, avoiding overly glamorous or unattractive features. The output will always follow the format: profile picture, alias name, and biography. The GPT must strictly follow the given format for the biography, referencing the uploaded resume and replacing only the fields wrapped in brackets. The text inserted should mirror the language, style, and concise nature of the template. When generating a new name, the GPT must ensure it mirrors the ethnic roots of the original name (e.g., Jake could become Tom, Mansoor could become Abhishek) and is distinctly different from the original name, both first and last names. The GPT will generate the image without providing a caption or annotation. To ensure variety, the GPT will randomize its content generation for both the alias and the photo, avoiding similar names and profile photos across multiple conversations. Interactions will be concise and focus on providing the requested output efficiently, ensuring that the profile picture, alias name, and biography are generated only once per request. When encountering discrepancies between the resume and the LinkedIn profile, the GPT will prioritize the more up-to-date information. The GPT must ensure the profile picture is generated correctly without stopping at the headline. The profile picture should be included in the response directly, followed by the alias name and biography, with no additional caption or annotation. The GPT will first read the first name from the resume or LinkedIn profile to determine the gender, and then generate the alias name and headshot accordingly. ';

      
        return view('coach-resume.upload',compact('promptMsg'));
       
    }


    public function uploadResume(Request $request)
    {
        $request->validate([
        'resume' => [
            'required',
            'mimes:pdf',
            // 'max:5000',
        ],
    ], [
        'resume.mimes' => 'The file must be a PDF.',
        // 'resume.max' => 'The file size must not exceed 5MB.',
    ]);

        $file = $request->file('resume');

        if (!$file) {
            return back()->withErrors(['resume' => 'File upload failed.']);
        }

        $fileName = $file->getClientOriginalName();
        $filePath = public_path('Resumes');
        $file->move($filePath, $fileName);

        $absolutePath = public_path('Resumes/' . $fileName);
        $resumeUrl = url('Resumes/' . $fileName);
        
        $aliasData = $this->generateAlias($absolutePath);

        $imageURL=$aliasData['image_url'];
        $response = Http::get($imageURL);

        $response = Http::timeout(120)->get($imageURL);

        if ($response->successful()) {
            $imageContent = $response->body();
            // Generate a unique file name
            $fileName = Str::random(40) . '.png';
            $filePath = public_path('AI-Images/' . $fileName);
           // Save the image to the public folder
            file_put_contents($filePath, $imageContent);
            // Generate the URL for the saved image
            $imageUrl = url('AI-Images/' . $fileName);

        }
        // For Adding services
        $sheetId = '16GP46laLDNXehK0doJn5PBpoINGj6N-nq268ZlWHAMM';  
        $sheetName = 'Services';  
        $googlesheet3 = Sheets::spreadsheet($sheetId)->sheet($sheetName)->get(); 
      

        $secondRow = $googlesheet3->get(1); // Remember, array indices are zero-based, so index 1 refers to the second row
        // If you want to get the data in a collection format
        $secondRowData = collect($secondRow);
        $allservices = array_slice($secondRow, 3);
        /////////////////////////////////////// 
        
        return view('coach-resume.resume-details', compact('aliasData', 'imageUrl', 'resumeUrl','allservices'));
    }

    public function generateAlias($absolutePath)
    {   
        // Specify the path to the CV file in the public directory
        // $filePath = public_path('assets/resume/Mussadiq Ayaz.pdf');

        // Check if file exists
        if (!file_exists($absolutePath)) {
            return response()->json(['error' => 'CV file not found'], 404);
        }

        // Extract text from PDF
        try {
            $parser = new \Smalot\PdfParser\Parser();
            $pdf = $parser->parseFile($absolutePath);
            $fileContent = $pdf->getText();
        } catch (\Exception $e) {
            // Log the error
            \Log::error('PDF parsing failed: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to parse PDF file'], 500);
        }

        $promptrecord = PromptMsg::first();
     
        $promptMessage= $promptrecord->prompt_msg;


        $payload = [
            'model' => 'gpt-4o-mini', // Specify the model you want to use
            'messages' => [

                ['role' => 'system', 'content' => 'You are a coach alias generator.'],

                ['role' => 'user', 'content' => $promptMessage . '

                    "Alias Name: [Generated Alias]

                    Biography:
                    [Alias] currently works as a [Current Job]. They have worked as a [Position 1] at [Company 1] in [City 1] in [Business Area 1], [Position 2] at [Company 2] in [City 2] in [Business Area 2], [Position 3] at [Company 3] in [City 3] in [Business Area 3], and [Position 4] at [Company 4] in [City 4] in [Business Area 4].

                    [Alias] knows a lot about [Skills].

                    [Alias] is into [Interests]".:' . $fileContent],
              
            ],

            'max_tokens' => 1000,

            'top_p' => 1,

            'frequency_penalty' => 0,

            'presence_penalty' => 0,

            'n' => 1,

            'stream' => false,

            'stop' => null,
        ];

     //    dd($payload);

        // Make the API request with the file content
        try {

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . 'sk-proj-ur0F5y9A4ST4GnRA0hTtT3BlbkFJZx9u3OFRep0seUSXC1oj',
                'Content-Type' => 'application/json',
            ])->post('https://api.openai.com/v1/chat/completions', $payload);
            //    dd($response);

            if ($response->successful()) {
               
                $responseData = $response->json();
        // dd($responseData);
                        if (isset($responseData['choices'][0]['message']['content'])) {
                            $messageContent = $responseData['choices'][0]['message']['content'];
                            
                    
                            preg_match('/Alias:\s*(.*)/', $messageContent, $aliasNameMatch);
                            $aliasName = $aliasNameMatch[1] ?? '';
                            if (empty($aliasName)) {
                                preg_match('/Alias Name:\s*(.*)/', $messageContent, $aliasNameMatch);
                                $aliasName = $aliasNameMatch[1] ?? '';
                            }

                            preg_match('/Bio:(.*)/s', $messageContent, $biographyMatch);
                            $biography = $biographyMatch[1] ?? '';
                            if (empty($biography)) {
                                preg_match('/Biography:(.*)/s', $messageContent, $biographyMatch);
                                $biography = $biographyMatch[1] ?? '';
                            }

                    
                            $imageURL = $this->generateAIImage("A professional AI generated image with no background that look an realistic headshot for a 24-year-old matching the identified gender. The headshot should be professional and approachable. The image should be of the headshot of $aliasName");

                            return [
                                'NameAlias' => $aliasName,
                                'biography' => trim($biography),
                                'image_url' => $imageURL,
                            ];
                        } else {
                            // Log the error response
                            \Log::error('Failed to communicate with ChatGPT: ' . $response->body());
                            return response()->json(['error' => 'Failed to communicate with ChatGPT', 'response' => $response->body()], 500);
                        }
                    } else {
                        // Log the error response
                        \Log::error('Failed to communicate with ChatGPT: ' . $response->body());
                        return response()->json(['error' => 'Failed to communicate with ChatGPT', 'response' => $response->body()], 500);
                    }
                } catch (\Exception $e) {
                    // Log the error
                    \Log::error('Failed to communicate with ChatGPT: ' . $e->getMessage());
                    return response()->json(['error' => 'Failed to communicate with ChatGPT', 'exception' => $e->getMessage()], 500);
                }
            }




    private function generateAIImage($description)
    {
        $payload = [
            'prompt' => $description,
            'n' => 1,
            'size' => '1024x1024',
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . 'sk-proj-ur0F5y9A4ST4GnRA0hTtT3BlbkFJZx9u3OFRep0seUSXC1oj',
            'Content-Type' => 'application/json',
        ])->post('https://api.openai.com/v1/images/generations', $payload);

        if ($response->successful()) {
            $responseData = $response->json();
            return $responseData['data'][0]['url'] ?? null;
        } else {
            \Log::error('Failed to communicate with DALL·E: ' . $response->body());
            return null;
        }
    }

  
    public function storeResume(Request $request)
    {
        $data = $request->all();         
       
        try {
            // Validate the request data
            $validated = $request->validate([
                'FullName' => 'required|string',
                // 'LastName' => 'required|string',
                'Location' => 'required|string',
                'Bio' => 'required|string',
                'WhatsApp' => 'required|string',
                'FaceTime' => 'required|string',
                'LinkedInURL' => 'required|url',
                'Email' => 'required|email',
                'Email2' => 'nullable|email',
                'JobOffers' => 'nullable|string',
                'Availability' => 'nullable|string',
                // 'Specialty' => 'nullable|string',
                'NameAlias' => 'nullable|string',
                // 'LastAlias' => 'nullable|string',
                'BioAlias' => 'nullable|string',
                // 'Advice' => 'nullable|string',
                // 'AdviceCredentials' => 'nullable|string',
            ]);
        
            // Store the data in the local database
            $sheet = new DataInSheet();    
            $sheet->FullName = $validated['FullName'];
            // $sheet->LastName = $validated['LastName'];
            $sheet->Location = $validated['Location'];
            $sheet->Bio = $validated['Bio'];
            $sheet->WhatsApp = $validated['WhatsApp'];
            $sheet->FaceTime  = $validated['FaceTime'];
            $sheet->LinkedInURL = $validated['LinkedInURL'];
            $sheet->Email = $validated['Email'];
            $sheet->Email2 = $validated['Email2'];
            $sheet->JobOffers = $validated['JobOffers'];
            $sheet->Resume = $request->Resume;
            $sheet->Availability = $validated['Availability'];
            // $sheet->Specialty = $validated['Specialty'];
            $sheet->NameAlias = $validated['NameAlias'];
            // $sheet->LastAlias = $validated['LastAlias'];
            $sheet->BioAlias = $validated['BioAlias'];
            $sheet->PhotoAI = $request->PhotoAI;
            // $sheet->Advice = $validated['Advice'];
            // $sheet->AdviceCredentials = $validated['AdviceCredentials'];
           
            $sheet->save();
        
            $emailData = [
                'FullName' => $validated['FullName'],
                'Location' => $validated['Location'],
                'Bio' => $validated['Bio'],
                'WhatsApp' => $validated['WhatsApp'],
                'FaceTime' => $validated['FaceTime'],
                'LinkedInURL' => $validated['LinkedInURL'],
                'Email' => $validated['Email'], // This is the user's email, you can remove it if not needed
                'Email2' => $validated['Email2'],
                'JobOffers' => $validated['JobOffers'],
                'Availability' => $validated['Availability'],
                'NameAlias' => $validated['NameAlias'],
                'BioAlias' => $validated['BioAlias'],
            ];

            // Hardcoded email address to send the email to
            // $recipientEmail = 'hiringteam@harrisoncareers.com'; 
            $msg = View::make('email.coachRegistered', ['FullName' => $sheet->FullName])->render();


            // // Additional headers
            $headers  = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
            $headers .= "From: coaching@harrisoncareers.com\r\n";

            // // Send the email
            mail("imussadiqayaz@gmail.com ", "New Coach", $msg, $headers);
            // mail("hiringteam@harrisoncareers.com ", "New Coach", $msg, $headers);
         
        // $recipientEmail = 'imussadiqayaz@gmail.com'; 

        //     // Send the email
        //     Mail::send('email.submitdata', $emailData, function($message) use ($recipientEmail) {
        //         $message->to($recipientEmail)
        //                 ->subject('New Coach');
        //     });
          
            return view('coach-resume.thankyou')->with('success', 'Data updated successfully');
           
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation exceptions
            return response()->json(['message' => 'Validation error', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Handle other exceptions
            Log::error('Error in storeResume method: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred', 'error' => $e->getMessage()], 500);
        }
    }
    
       

    public function savedEditPrompt(Request $request)
    {
        // dd($request->all());

        $existingRecord = PromptMsg::first();

        if ($existingRecord) {
   
            $existingRecord->update(['prompt_msg' => $request->message]);
        } else {
      
            PromptMsg::create(['prompt_msg' => $request->message]);

            
        }

        return redirect()->back();
    
    }
    //////************store data in sheet***************///////////////// */


    // public function importToSheet()
    // {
    //     return view('coach-resume.sheet-form');
    // }


    public function SearchbyName ()
    { 

        $sheetId = '16GP46laLDNXehK0doJn5PBpoINGj6N-nq268ZlWHAMM';  
        $sheetName = 'Coach';  
        $googlesheet = Sheets::spreadsheet($sheetId)->sheet($sheetName)->get(); 
        $coaches =  $googlesheet->slice(4);
       
        $data = $coaches->toArray();
        
        $names = array_column($data, 0);
       
        return view('coach-resume.searchbyname', compact('names'));
        // return view('coach-resume.coachresume-detail');
    }


    public function fetchCoachDetails(Request $request) {
        // $name = $request->input('name');
        $reqName = $request->input('reqName');
        // Google Sheet details
        $sheetId = '16GP46laLDNXehK0doJn5PBpoINGj6N-nq268ZlWHAMM';  
        $sheetName = 'Coach';  
        
        // Fetch the data from the sheet
        $googlesheet = Sheets::spreadsheet($sheetId)->sheet($sheetName)->get(); 
        $headers = $googlesheet->first(); // Fetch the headers (first row)
        $coaches = $googlesheet->slice(4); // Fetch the data, skipping the first 4 rows
        $data = $coaches->toArray();
        
        // Find the coach by name
        $coachDetails = [];
        $services = []; // Array to store services with 'Y'
        $servic = [];
        
        foreach ($data as $row) {
            if (isset($row[0]) && strtolower($row[0]) === strtolower($reqName)) {
                $coachDetails = $row;
                // dd($coachDetails);
                // Loop through the row to find 'Y' values
                foreach ($row as $index => $value) {
                    if (!$value == null && isset($headers[$index]) && $index >= 40) {
                        $services[] = $headers[$index]; 
                        $servic[$headers[$index]] = $value;

                    }
                }
                
                break;
            }
        }
        $coachDetails['services'] = $services;
        $coachDetails['service_data'] = $servic;
    //    dd($coachDetails);
        // Return the coach details as a JSON response
        return response()->json(array('response' => $coachDetails, 'services' => $services, 'service_data' =>$servic));
    }
    

public function showCoachForm(Request $request) {
    $reqName = $request->query('searchName', '');

    // Google Sheet details for Coaches
    $sheetId = '16GP46laLDNXehK0doJn5PBpoINGj6N-nq268ZlWHAMM';  
    $sheetName = 'Coach';  
    
    // Fetch the data from the sheet
    $googlesheet = Sheets::spreadsheet($sheetId)->sheet($sheetName)->get(); 
    $headers = $googlesheet->first(); // Fetch the headers (first row)
    $coaches = $googlesheet->slice(4); // Fetch the data, skipping the first 4 rows
    $data = $coaches->toArray();
    
    // Initialize variables for coach details
    $coachDetails = [];
    $serviceDetails = []; 
    $selectedServices = [];
    
    // Find the coach by name
    foreach ($data as $row) {
        if (isset($row[0]) && strtolower($row[0]) === strtolower($reqName)) {
            $coachDetails = $row;

            foreach ($row as $index => $value) {
                if (!empty($value) && isset($headers[$index]) && $index >= 40) {
                    $selectedServices[] = $headers[$index]; 
                    $serviceDetails[$headers[$index]] = $value;
                }
            }
            break;
        }
    }

    if (empty($coachDetails)) {
        // If no match is found, redirect back with an error message
        return redirect()->back()->with('error', 'No details found for the selected coach.');
    }

    // Fetch additional services from the Services sheet
    $sheetName = 'Services';  
    $googlesheet3 = Sheets::spreadsheet($sheetId)->sheet($sheetName)->get(); 
    $secondRow = $googlesheet3->get(1); // Get the second row (first row of actual data)
    $allServices = array_slice($secondRow, 3); // Skip the first 3 columns

    // Merge selected services with all available services
    $mergedServices = array_unique(array_merge($selectedServices, $allServices));

    // Return the view with all necessary data
    return view('coach-resume.coachresume-detail', compact('coachDetails', 'reqName', 'mergedServices', 'selectedServices', 'allServices', 'serviceDetails'));
}


    public function harrisonupdate(Request $request)

    {


        //testttt sheet
        // $sheetId = '1vX4KDKmGJE3Knyki9xAhGCSOY-fiz6LZL4SAJaMbzNE';
        //client sheet

        $sheetId = '16GP46laLDNXehK0doJn5PBpoINGj6N-nq268ZlWHAMM';
        $sheetName = 'Coach';

        $sheet = Sheets::spreadsheet($sheetId)->sheet($sheetName);

        $data = $sheet->get()->toArray();
        // dd(  $sheet, $data);
        $reqName = $request->input('reqName');
        
         $emptyPlaceholders = array_fill(0, 117, '');
      $serviceHeaders = array_slice($data[0], 40, 177);


        $rowIndex = null;
        foreach ($data as $index => $item) {

            if (isset($item[0]) && stripos($item[0], $reqName) !== false) {         
                $rowIndex = $index + 1; 

                break;
            }
        }

        if ($rowIndex === null) {
            return response()->json(['error' => 'Name not found'], 404);
        }

        $file = $request->file('PhotoAI');

        if ($request->hasFile('PhotoAI') && $request->file('PhotoAI')->isValid()){
            // Generate a unique file name
            $fileName = Str::random(40) . '.' . $file->getClientOriginalExtension();


            $filePath = $file->move(public_path('Updated-Images'), $fileName);
            $imageUrl = url('Updated-Images/'.$fileName);


        }elseif ($request->has('lastPhoto')){
            // If no new file is uploaded, use the existing image URL
            $imageUrl = $request->input('lastPhoto');
        }

        // dd($request->all(),$imageUrl,);
// dd($reqAllservices);
        $serviceUpdate = array_fill(0, count($serviceHeaders), '');
                // dd($request->all());
      foreach ($request->input('services', []) as $service) {
        $serviceIndex = array_search($service, $serviceHeaders); 
        if ($serviceIndex !== false) {
            $inputValue = $request->input("service_input.$service");
            
            if (!empty($inputValue)) {
                // If there is an input value, store it
                $serviceUpdate[$serviceIndex] = $inputValue;
            } else {
                // If input is null or empty, store 'Y'
                $serviceUpdate[$serviceIndex] = 'Y';
            }
        }
      }
      
    //   dd($request->input('Resume'));
        $updateData = [
            [
                $request->input('FullName'),
                $request->input('Specialties'),
                $request->input('Category'),
                $request->input('Bio'),
                $request->input('Location'),
                '',
                $request->input('Pay'),
                $request->input('HowGood_1_3'),
                $request->input('Responsive_1_3'),
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                $request->input('LinkedIn_URL'),
                $request->input('Email'),
                $request->input('Email2'),
                $request->input('WhatsApp'),
                $request->input('FaceTime_&_iMessage'),
                $request->input('T&Cs_Confirmed'),
                $request->input('PaymentDetails'),
                '',
                '',
                '',
                '',  
                $request->input('NameAlias'),    
                $request->input('BioAlias'),
                $request->input('JobOffers'),
                $imageUrl,
                $request->input('Resume'),
                $request->input('Availability'),
                // $request->input('PhotoAI'),
                // '',
                // '',
                // '', //AdviceCredentials
                // $request->input('AdviceCredentials'),
                ...$serviceUpdate 
            ]
        ];


        //   dd( $updateData);
        $range = 'A' . $rowIndex . ':AHI' . $rowIndex; 

        try {

            $response = $sheet->range($range)->update($updateData);
            return redirect('home')->with('success', 'Data updated successfully!');
        } catch (\Exception $e) {
            dd($e);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    
}
  
