<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Mail\Mailable;
use Illuminate\Http\Request;

use App\User;
use App\Patients;
use App\VisitStatus;
use App\QuotationStatus;
use Mail;

class PatientController extends Controller
{

    protected $patientsModel;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->patientsModel = new Patients();
    }

    /**
     * Show the Patient List.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $dentist_id =Auth::user()->id;
        $dentist_name = Auth::user()->name . ' ' . Auth::user()->surname;
        $business_name = Auth::user()->business_name;
        $patients = $this->patientsModel->getAllPatientsByDentistID($dentist_id);

        return view('patients', ['patients' => $patients, 'dentist_name' => $dentist_name, 'business_name' => $business_name]);
    }

    /**
     * Show the Patient Information
     *
     * @param  \App\Patient  $model
     * @param  Int $id
     *
     * @return \Illuminate\View\View
     */

    public function edit($id)
    {
        $patient_data = $this->patientsModel->getByID($id);
        $visit_status = VisitStatus::all();
        $quotation_status = QuotationStatus::all();
        return view('patient', ['patient' => $patient_data, 'visit_status' => $visit_status, 'quotation_status' => $quotation_status]);
    }

    /**
     *
     * Update Patient Visit information

     *@param  Illuminate\Http\Request
     *
     * @return View
     */

    public function update_info(Request $request)
    {
        $data = $request->all();
        $id = $data['id'];

        // Get Patient Model
        $patient = Patients::find($id);

        if( $patient ) {
            $patient->visit_status = $data['visit_status'];
            $patient->quotation_status = $data['quotation_status'];
            $patient->total_accepted_quotation = $data['total_accepted_quotation'];
            $patient->total_collected = $data['total_collected'];
            $result = $patient->save();
        }

        if($result) {
            return response()->json(['success' => true, 'result' => $result]);
        }
        // return redirect()->route('patients.edit', $id)->withStatus(__('User successfully updated.'));
    }

    /**
     *  Create new Patient Book
     *
     * @param  Illuminate\Http\Request;
     *
     * @return Json
     */

     public function create(Request $request)
     {

        $data = $request->all();
        $name_surname = $data['title'];
        $phone_number = $data['phone_number'];
        $dentist_id = $data['dentist_id'];
        $calendar_id = $data['id'];
        $first_visit_start = $data['start'];
        $first_visit_end = $data['end'];

        $result = $this->patientsModel->create([
            'name_surname' => $name_surname,
            'phone_number' => $phone_number,
            'dentist_id' => $dentist_id,
            'calendar_id' => $calendar_id,
            'first_visit_start' => $first_visit_start,
            'first_visit_end' => $first_visit_end
        ]);

        /*  ToDo remove this on product mode
        if( $result ){
            $dentist = User::where('id', '=', $dentist_id)->first();
            if( $dentist ){
                $email = $dentist->email;
                 Mail::send([], [], function ($message) use ($name_surname, $phone_number, $first_visit_start, $dentist, $email) {
                    $reminder_date = (new \DateTime('@' . $first_visit_start))->sub(new \DateInterval('P3D'));
                    $first_visit_date  = new \DateTime('@'. $first_visit_start);
                    $body = __('Dear ') . $dentist->name . ' ' . $dentist->surname . ',';
                    $body .= "<br/>";
                    $body .= __('New Patient has been assigned.')."<br/>";
                    $body .= __('Patient Name:  ') . $name_surname . '<br/>';
                    $body .= __('Phone Number:  ') . $phone_number . '<br/>';
                    $body .= __('First Visit Date:  ') . $first_visit_date->format('Y-m-d') . '<br/>';

                    $message->to($email)->subject(__('Assigned Patient Notification'))->setBody($body, 'text/html');
                });
            }
        }
        */

        return response()->json(['result' => true]);
     }

    /**
     *  Update Patient Book
     *
     * @param  Illuminate\Http\Request;
     *
     * @return Json
     */
    public function update(Request $request)
    {
        $data = $request->all();
        $id = $data['id'];

        $patient = Patients::where('calendar_id', '=', $id)->first();

        if($patient){
            $patient->name_surname = $data['title'];
            $patient->phone_number = $data['phone_number'];
            $patient->dentist_id = $data['dentist_id'];
            $patient->first_visit_start = $data['start'];
            $patient->first_visit_end = $data['end'];

            $result = $patient->save();
        } else {
            $result = ['success' => 'failed'];
        }

        return response()->json(['result' => $result]);

    }

    /**
     *  Delete Patient Book
     *
     * @param  Illuminate\Http\Request;
     *
     * @return Json
     */
    public function delete(Request $request)
    {

        $id = $request->input('id');
        $patient = Patients::where('calendar_id', '=', $id)->first();

        if($patient){
            $result = $patient->delete();
        } else {
            $result = ['success' => 'failed'];
        }

        return response()->json(['result' => $result]);

    }

}
