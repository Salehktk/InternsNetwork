<?php

namespace App\Http\Controllers;

use Log;
use App\Models\Resume;
// use Sheets;
use App\Mail\ClientMail;
use App\Models\AdminSetup;
use App\Mail\CoachToClient;

use App\Mail\SendMailToAll;
use App\Mail\ClientLastMail;
use App\Mail\FormSubmission;
use App\Models\CochingSetup;
use Illuminate\Http\Request;
use App\Mail\CoachSubmitMail;
use App\Mail\SendMailToCoach;

use App\Models\CoachFeedback;
use App\Models\ClientFeedback;
use App\Mail\MailToClientAdmin;
use App\Mail\CoachingSubmission;
use App\Mail\MailToCoachAndOther;
use App\Mail\MailToClientandOther;
use Illuminate\Auth\Events\Failed;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use function PHPUnit\Framework\returnSelf;
use Revolution\Google\Sheets\Facades\Sheets;



class GoogleServiceController extends Controller
{

    private $_request = null;
    private $_coachsetup = null;



    public function __construct(Request $request, CochingSetup $coachsetup)
    {

        $this->_request = $request;
        $this->_coachsetup = $coachsetup;
    }
    public function index()
    {
        return view('coachingrequest');
    }




    public function coachingrequest()
    {

        $googlesheet = Sheets::spreadsheet('16GP46laLDNXehK0doJn5PBpoINGj6N-nq268ZlWHAMM')->sheet('Clients')->get();
        // $googlesheet = Sheets::spreadsheet('14il32mUVrSjaCpYypvfxhY3b5_M8YnhoTooxxTyzI5U')->sheet('Clients')->get();


        $header = $googlesheet->pull(1);
        $data = $googlesheet->all();
        $values = Sheets::collection($header, $data)->toArray();

        $googlesheet2 = Sheets::spreadsheet('16GP46laLDNXehK0doJn5PBpoINGj6N-nq268ZlWHAMM')->sheet('Coach')->get();

        $header2 = $googlesheet2->pull(0);

        $values2 = array_slice($header2, 40);

        $names = array_column($values, 'FullName');
        $biographies = array_column($values, 'status');

        $nameBiographyMap = array_combine($names, $biographies);

// dd($nameBiographyMap );
        // $coachBiographyMap = [];
        $coachBiographyMap = [];

        foreach ($values as $value) {
            $email = isset($value['Primary Email']) ? $value['Primary Email'] : '';

            if (!empty($value['First Name']) && !empty($value['Last Name'])) {
                $fullName = $value['First Name'] . ' ' . $value['Last Name'];
                $coachBiographyMap[$fullName] = [
                    'Primary Email' => $email,
                ];
            }
        }


        return view('coachingrequest', compact(['values', 'values2', 'coachBiographyMap']));
    }





    public function submitRequest()
    {
        // dd($this->_request->all());
        try {
            $user = Auth::user();

            $validationRules = [
                'interviewDetails' => 'required|string|max:300',
                'client' => 'required|string',
                'userEmails' => 'nullable|string',
                'deadline' => 'required|date',
                'service' => 'required|string',
                'setupNotes' => 'required|string|max:300',
            ];

            if ($user->email === 'peter.harrison@harrisoncareers.com') {
                $validationRules['userEmails'] = 'nullable|string';
            }

            $this->_request->validate($validationRules);


            $clientmail = $this->_request->only('userEmails');

            $data =  $this->_request->all();

            if ($user->email === 'peter.harrison@harrisoncareers.com' && isset($data['userEmails'])) {
                // Ensure userEmails is a string
                $data['userEmails'] = implode(',', explode(',', $data['userEmails']));
            } else {
                $data['userEmails'] = null;
            }

            $save = $this->_coachsetup->create($data);

            $alysaa = ['alyssa.richmond@harrisoncareers.com'];
            // $alysaa = ['sharjeelkhokhar94@gmail.com'];
           

            $recipients = ['peter.harrison@harrisoncareers.com', 'majidfazal@gmail.com'];
            //  $recipients = ['imussadiqayaz@gmail.com', 'salehktk1@gmail.com'];
          
            

            $identifier = $save->identifier;


            $recipients = array_map('trim', $recipients);

            Mail::to($alysaa)->cc($recipients)->send(new FormSubmission($data, $identifier));

            $selectedClient = $this->_request->input('selectedCoach');

            // Mail::to($clientmail)->send(new ClientMail($selectedClient, $save, $identifier));

            return back()->with('success', 'Form submitted successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to submit form: ' . $e->getMessage());
        }
    }


    public function coachingSetup()
    {

        $googlesheet = Sheets::spreadsheet('16GP46laLDNXehK0doJn5PBpoINGj6N-nq268ZlWHAMM')->sheet('Clients')->get();
        // $googlesheet = Sheets::spreadsheet('14il32mUVrSjaCpYypvfxhY3b5_M8YnhoTooxxTyzI5U')->sheet('Clients')->get();

        $header = $googlesheet->pull(1);
        $data = $googlesheet->all();
        $values = Sheets::collection($header, $data)->toArray();


        $googlesheet2 = Sheets::spreadsheet('16GP46laLDNXehK0doJn5PBpoINGj6N-nq268ZlWHAMM')->sheet('Coach')->get();

        $header2 = $googlesheet2->pull(0);

        $values2 = array_slice($header2, 40);


        return view('index', compact(['values', 'values2']));
    }

    public function submitForm()
    {
        try {
            $user = Auth::user();

            $validationRules = [
                'interviewDetails' => 'required|string|max:300',
                'client' => 'required|string',
                'userEmails' => 'nullable|string',
                'deadline' => 'required|date',
                'service' => 'required|string',
                'setupNotes' => 'required|string|max:300',
                'status' => 'nullable|string',
            ];

            if ($user->email === 'peter.harrison@harrisoncareers.com') {
            }

            $this->_request->validate($validationRules);
            $data['status'] = 0;
            $data =  $this->_request->all();

            $save = $this->_coachsetup->create($data);

            $peter =['peter.harrison@harrisoncareers.com',];
            // $peter ='muarijmamoon@gmail.com';
         
            $recipients = ['alyssa.richmond@harrisoncareers.com','majidfazal@gmail.com'];
            // $recipients = ['sumayanazir440@gmail.com','imussadiqayaz@gmail.com'];
         

            $identifier = $save->identifier;


            $recipients = array_map('trim', $recipients);

            Mail::to($peter)->cc($recipients)->send(new FormSubmission($data, $identifier));

            return back()->with('success', 'Form submitted successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to submit form: ' . $e->getMessage());
        }
    }


    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
    public function user()
    {
        $user = $this->_coachsetup->latest()->get();
        return view('users.show', compact('user'));
    }

    public function coachingSetupShow()
    {
        $user = $this->_coachsetup->latest()->get();
        return view('users.coachsetupshow', compact('user'));
    }


    public function edit($id)
    {
        $user = $this->_coachsetup->find($id);

        $googlesheet = Sheets::spreadsheet('16GP46laLDNXehK0doJn5PBpoINGj6N-nq268ZlWHAMM')->sheet('Clients')->get();
        // $googlesheet = Sheets::spreadsheet('14il32mUVrSjaCpYypvfxhY3b5_M8YnhoTooxxTyzI5U')->sheet('Clients')->get();

        $header = $googlesheet->pull(1);
        $data = $googlesheet->all();
        $values = Sheets::collection($header, $data)->toArray();
        // $values = Sheets::array_slice($header);

        $googlesheet2 = Sheets::spreadsheet('16GP46laLDNXehK0doJn5PBpoINGj6N-nq268ZlWHAMM')->sheet('Coach')->get();

        $header2 = $googlesheet2->pull(0);

        $values2 = array_slice($header2, 40);


        return view('users.edit', compact(['values', 'values2', 'user']));
    }

    public function update($id)
    {
        $user = $this->_coachsetup->find($id);
        $user->update($this->_request->all());
        $identifier = $user->identifier;

        $recipients = ['alyssa.richmond@harrisoncareers.com', 'peter.harrison@harrisoncareers.com', 'majidfazal@gmail.com'];
       

        Mail::to($recipients)->send(new FormSubmission($user, $identifier));

        return redirect()->route('users')->with('success', 'Record updated successfully');
    }
    public function destroy($id)
    {
        $user = $this->_coachsetup->find($id);
        $user->delete();
        return redirect()->route('users')->with('error', 'Record deleted successfully');
    }

    public function coachSetupEdit($id)
    {
        $user = $this->_coachsetup->find($id);

        $googlesheet = Sheets::spreadsheet('16GP46laLDNXehK0doJn5PBpoINGj6N-nq268ZlWHAMM')->sheet('Clients')->get();
        // $googlesheet = Sheets::spreadsheet('14il32mUVrSjaCpYypvfxhY3b5_M8YnhoTooxxTyzI5U')->sheet('Clients')->get();

        $header = $googlesheet->pull(1);
        $data = $googlesheet->all();
        $values = Sheets::collection($header, $data)->toArray();
        // dd($values);

        $googlesheet2 = Sheets::spreadsheet('16GP46laLDNXehK0doJn5PBpoINGj6N-nq268ZlWHAMM')->sheet('Coach')->get();
        $index = null;
        $serviceClient = [];

       
        foreach ($googlesheet2 as  $key => $singleLineForall) {
           
            foreach ($singleLineForall  as  $key => $singleLine) {
            
                if ($singleLine  ==  $user->service) {
                    $index = $key;
                    break;
                }
            }
            if (isset($singleLineForall[$index])) {

                if ($singleLineForall[$index] == 'Y') {
                    array_push($serviceClient, $singleLineForall);
                }
            }
        }
        // dd($client);

        $header2 = $googlesheet2->pull(0);

        $values2 = array_slice($header2, 40);



        $sheetId = '16GP46laLDNXehK0doJn5PBpoINGj6N-nq268ZlWHAMM';
        $sheetName = 'Services';

        try {
            $googlesheet3 = Sheets::spreadsheet($sheetId)->sheet($sheetName)->get();
          
            
            $header3 = $googlesheet3->pull(1);
            
            $values3 = array_slice($header3, 3);

            
        } catch (\Exception $e) {
            
            dd('Error fetching sheet: ' . $e->getMessage());
        }

        // $googlesheet3 = Sheets::spreadsheet('16GP46laLDNXehK0doJn5PBpoINGj6N-nq268ZlWHAMM')->sheet('Services')->get();

        // dd($googlesheet3);
        // $header3 = $googlesheet3->pull(1);

        // $values3 = array_slice($header3, 3);


        // $googlesheet4 = Sheets::spreadsheet('16GP46laLDNXehK0doJn5PBpoINGj6N-nq268ZlWHAMM')->sheet('Coach')->get();

        // $header4 = $googlesheet4->pull(0);
        $data4 = $googlesheet2->all();

       

        // dd(count($data4));
        if (count($data4) >= 3) {


            $filteredData1 = array_slice($data4, 3, null, true);
            // dd($filteredData1);
        } else {
            echo "Array doesn't have enough elements.";
        }

        $values4 = Sheets::collection($header2, $filteredData1)->toArray();
    
        $names = array_column($values4, 'FullName');

        $biographies = array_column($values4, 'Bio');

        $nameBiographyMap = array_combine($names, $biographies);

        $coachBiographyMap = [];

        foreach ($values4 as $value) {
            $biography = isset($value['Bio']) ? $value['Bio'] : '';
            $coachmail = isset($value['Email']) ? $value['Email'] : ''; // Check if 'coachmail' key exists

            $coachBiographyMap[$value['FullName']] = [
                'Bio' => $biography,
                'coachmail' => $coachmail
            ];
        }
        // dd($coachBiographyMap);


        return view('users.coachsetupedit', compact(['values', 'values2', 'values3', 'user', 'values4', 'serviceClient', 'coachBiographyMap']));
    }


    public function coachingSetupUpdate($id)
    {
        // dd($this->_request->all());

        $user = $this->_coachsetup->find($id);
        $data = $this->_request->except('_token', 'resume');


        $coachmail = $this->_request->only('coachmail');
        $identifier = $user->identifier;

        $data['status'] = 1;



        if ($this->_request->hasfile('resume')) {
           
            $fileNames = [];

            foreach ($this->_request->file('resume') as $file) {
                $originalFileName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();


                $fileNameToStore = $originalFileName . '_' . time() . '.' . $extension;
                $file->storeAs('resumes', $fileNameToStore);
                $fileNames[] = $fileNameToStore;
            }

            $data['resume'] = json_encode($fileNames);

            $admin = AdminSetup::updateOrCreate(['identifier' => $user->identifier], $data);

           
            $this->_coachsetup->where('id', $id)->update(['status' => $data['status']]);
        } else {

            return redirect()->back()->with('error', 'Please upload at least one file.');
        }
  
        /***********---client name and email---************ */
        $new = $this->_coachsetup->where('identifier', $identifier)->first();

        $clientName = $new->client;
        $clientMail = $new->userEmails;

        /**__________--End-client name and email---________* */

        //  dd($admin);
         try {
            $peter = ['peter.harrison@harrisoncareers.com'];
            $recipients = ['majidfazal@gmail.com', 'alyssa.richmond@harrisoncareers.com'];
            $clientandcc = ['peter.harrison@harrisoncareers.com', 'alyssa.richmond@harrisoncareers.com', 'majidfazal@gmail.com'];
           
            Mail::to($peter)->cc($recipients)->send(new CoachingSubmission($admin, $identifier));
        
            $selectedCoach = $this->_request->input('selectedCoach');
            Mail::to($coachmail)->send(new SendMailToCoach($selectedCoach, $admin, $identifier));
        
            Mail::to($clientMail)->cc($clientandcc)->send(new MailToClientAdmin($clientName, $admin, $identifier));
            sleep(1);
        } catch (\Exception $e) {
          
            return redirect()->back()->with('error', 'An error occurred while sending emails.');
        }
          return redirect()->route('coachingsetupshow')->with('success', 'Record updated successfully');
    }


    public function questionAnswer()
    {
        ///************ Get All services from  Googlesheet************** */
        // $googlesheet4 = Sheets::spreadsheet('16GP46laLDNXehK0doJn5PBpoINGj6N-nq268ZlWHAMM')->sheet('Questions')->get();
        $googlesheet4 = Sheets::spreadsheet('16GP46laLDNXehK0doJn5PBpoINGj6N-nq268ZlWHAMM')->sheet('Services')->get();
        $index2 = null;
        $question = [];

        $QestioninServices =  $googlesheet4->slice(10);
        $batch =  $this->_request->question;
// dd($googlesheet4, $batch, $QestioninServices );

        $header4 = $googlesheet4->pull(0);
        $data4 = $googlesheet4->all();
        foreach ($data4 as $key1 => $value) {

            foreach ($value as $key2 => $value2) {

                if ($value2 == $batch) {

                    $index2 =  $key2;
                    break;
                }
            }

            if ($key1 != 2 && isset($value[$index2])) {

                if ($value[$index2] ==  '1') {

                    $question[] =  $value[0];
                }
            }
        }

        return view('questionAnswer', compact('question'));
    }

    public function saveFeedback()
    {

        $identifier = $this->_request->input('identifier');

        $new = $this->_coachsetup->where('identifier', $identifier)->first();
        $status['status'] = 2;

        $this->_coachsetup->where('identifier', $identifier)->update(['status' => $status['status']]);
        $email = $new->userEmails;
        
        // dd($new);
        $client_name = $new->client;

        $existingFeedback = CoachFeedback::where('identifier', $identifier)->exists();
        if ($existingFeedback) {
            return redirect()->back()->with('error', 'Feedback already submitted');
        } else
            $validatedData = $this->_request->validate([
                'batch' => 'required',
                'questions' => 'required|array',
                'feedbacks' => 'required|array',
                'gradings' => 'required|array|',
                'summaryfeedback' => 'required',
                'overallgrading' => 'required',
            ]);
        if (!$validatedData) {
            return redirect()->back()->with('error', 'Feedback submitted');
        }

        $savecoachfeedbacks = [];

        foreach ($validatedData['questions'] as $index => $question) {

            $savecoachfeedbacks[] = CoachFeedback::create([
                'identifier' => $identifier,
                'batch' => $validatedData['batch'],
                'question' => $question,
                'feedback' => $validatedData['feedbacks'][$index],
                'grading' => $validatedData['gradings'][$index],
                'summaryfeedback' => $validatedData['summaryfeedback'],
                'overallgrading' => $validatedData['overallgrading'],
            ]);
        }

        $recipients = ['alyssa.richmond@harrisoncareers.com', 'peter.harrison@harrisoncareers.com', 'majidfazal@gmail.com'];

        Mail::to($email)->send(new CoachToClient($savecoachfeedbacks, $identifier, $client_name));

        Mail::to($recipients)->send(new CoachSubmitMail($savecoachfeedbacks, $identifier));

        return redirect()->back()->with('success', 'Feedback submitted successfully!');
    }

    public function showFeedback($identifier)
    {

        $user_identi = $this->_request->identifier;


        $item = $this->_coachsetup->where('identifier', $user_identi)->get();
        $adminsetup = AdminSetup::where('identifier', $user_identi)->get();
        $coachfeedbacks = CoachFeedback::where('identifier', $user_identi)->get();

        $client_feedback = ClientFeedback::where('identifier', $user_identi)->get();

        return view('users.showfeedback', compact(['adminsetup', 'item', 'coachfeedbacks', 'client_feedback']));
    }

    public function clientFeedback($identifier)
    {

        $feedbackSubmitted = ClientFeedback::where('identifier', $identifier)->exists();


        return view('clientFeedback', compact('identifier', 'feedbackSubmitted'));
    }


    public function submit_feedback()
    {
        $new = $this->_coachsetup->where('identifier', $this->_request->input('identifier'))->first();
        $identifier = $this->_request->input('identifier');
        $clientmail = $new->userEmails;

        $client_name = $new->client;
        $status['status'] = 3;

        $this->_coachsetup->where('identifier', $identifier)->update(['status' => $status['status']]);

        $newmail = AdminSetup::where('identifier', $this->_request->input('identifier'))->first();

        $coachmail = $newmail->coachmail;

        $validatedData = $this->_request->validate([
            'identifier' => 'string',
            'question_1' => 'required|in:Yes,No',
            'question_2' => 'required|string|min:50',
            'question_3' => 'required|in:Yes,No',
        ]);
        if (!$validatedData) {
            return redirect()->back()->with('error', 'Feedback is Submitted for this identifier.');
        }

        $existingFeedback = ClientFeedback::where('identifier', $identifier)->exists(); {
            if ($existingFeedback) {
                return redirect()->back()->with('error', 'Feedback already submitted');
            } else
                ClientFeedback::create($validatedData);

            $recipients = ['alyssa.richmond@harrisoncareers.com', 'peter.harrison@harrisoncareers.com', 'majidfazal@gmail.com'];

            $ccEmails = ['alyssa.richmond@harrisoncareers.com', 'peter.harrison@harrisoncareers.com', 'majidfazal@gmail.com'];

            // array_push($ccEmails, $clientmail);


            if ($validatedData['question_3'] == 'Yes') {

                Mail::to($coachmail)->cc($recipients)->send(new SendMailToAll($coachmail, $clientmail));
                Mail::to($clientmail)->send(new ClientLastMail($identifier, $ccEmails, $client_name));
            } else {

                Mail::cc($ccEmails)->send(new MailToClientandOther($clientmail, $client_name));
            }

            $feedbackSubmitted = $validatedData['question_3'] == 'Yes' && $existingFeedback;
            session(['feedbackSubmitted' => $feedbackSubmitted]);
            return redirect()->back()->with('success', 'Feedback is Submitted for this identifier.');
        }
    }


    public function clientSession()
    {

        // dd($this->_request->all());
        $user_identi = $this->_request->identifier;
        $client_name = $this->_request->client;
        $googlesheet4 = Sheets::spreadsheet('16GP46laLDNXehK0doJn5PBpoINGj6N-nq268ZlWHAMM')->sheet('Services')->get();
        $index2 = null;
        $question = [];
        $batch =  $this->_request->batch;
        // dd( $batch);
        // dd($googlesheet4);
        $header4 = $googlesheet4->pull(0);
        $data4 = $googlesheet4->all();
        foreach ($data4 as $key1 => $value) {

            foreach ($value as $key2 => $value2) {

                if ($value2 == $batch) {

                    $index2 =  $key2;
                    break;
                }
            }

            if ($key1 != 2 && isset($value[$index2])) {

                if ($value[$index2] ==  '1') {

                    $question[] =  $value[0];
                }
            }
        }

        // dd($client_name);


        // $coachfeedbacks = CoachFeedback::where('identifier', $user_identi)->first();
        // dd( $coachfeedbacks);
        return view('clientsession', compact('question', 'user_identi', 'client_name'));
    }

}
