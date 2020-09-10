<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Schedules;
use App\Patients;


class CalendarController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the Calendar
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user_info = Auth::user();
        $user_name = $user_info->name.' '.$user_info->surname;
        $business_name = $user_info->business_name;
        $dentist_id = $user_info->id;
        $self_manager = $user_info->self_manager;
        return view('calendar', compact('dentist_id', 'user_name', 'business_name', 'self_manager'));
    }

    public function patient_book($id) {

        $dentist_id = $id;
        $dentist_info = User::find($dentist_id);
        $user_name = $dentist_info->name.' '.$dentist_info->surname;
        $business_name = $dentist_info->business_name;
        $self_manager = false;
        return view('calendar', compact('dentist_id', 'user_name', 'business_name', 'self_manager'));

    }

    /**
     *  Schedules
     *
     * @param Illuminate\Http\Request
     *
     * @return JSON $schedules
     */

    public function schedules(Request $request)
    {

        $user_role = Auth::user()->role;
        $self_manager = Auth::user()->self_manager;

        $start = $request->input('start');
        $end = $request->input('end');
        $dentist_id = $request->input('dentist_id');

        $response = array();

        $dentist_schedule = Schedules::where('dentist_id', '=', $dentist_id)->get();
        $patient_books = Patients::where('dentist_id', '=', $dentist_id)->get();

        foreach($dentist_schedule as $d){
            $schedule_data = [
                'id'          => $d->calendar_id,
                'category'    => 'dentist_ft',
                'title'       => $d->title,
                'start'       => $d->start,
                'end'         => $d->end,
                'dentist_id'  => $dentist_id,
                'patient_id'  => "",
                'phone_number'=> "",
                'read_only'   => false
            ];
            if( $user_role != 2 ){
                $schedule_data['read_only'] = true;
            }

            if( !$self_manager ) {
                $response[] = $schedule_data;                
            }

        }

        foreach ($patient_books as $p) {
            $schedule_data = [
                'id'          => $p->calendar_id,
                'category'    => 'patients',
                'title'       => $p->name_surname,
                'start'       => $p->first_visit_start,
                'end'         => $p->first_visit_end,
                'dentist_id'  => $dentist_id,
                'patient_id'  => $p->id,
                'phone_number'=> $p->phone_number,
                'read_only'   => false
            ];

            if( $user_role == 2 && !$self_manager){
                $schedule_data['read_only'] = true;
            }

            $response[] = $schedule_data;
        }

        return response()->json($response);


    }


    /**
     *
     * Download Patient Book informatiion of Dentist
     *
     * @param Illuminate\Http\Request
     *
     * @return Json
     */
    public function download_csv()
    {

        $dentist_id = Auth::user()->id;
        $date = date('Y-m-d');

        $criteria_start_date =(new \DateTime($date))->modify('+3 day')->format('Y-m-d');
        $criteria_end_date = (new \DateTime($date))->modify('+4 day')->format('Y-m-d');

        $patients = Patients::where('dentist_id', '=', $dentist_id)
            ->where('first_visit_start', '>', $criteria_start_date)
            ->where('first_visit_start', '<', $criteria_end_date)
            ->get();

        $csvExporter = new \Laracsv\Export();
        $csvExporter->beforeEach(function ($patient) {
            $patient->visit_date = (new \DateTime($patient->first_visit_start))->format('d/m/Y');
            $patient->visit_time = (new \DateTime($patient->first_visit_start))->format('H:i');
        });

        $csvExporter->build($patients, ['name_surname'=>'name', 'phone_number', 'visit_date', 'visit_time'],
        ['header' => false,])->download();
        // P.- added ,['header' => false,] check if it works.
        // return response()->json(['result' => $patients]);

    }

    /**
     * Confirmation available create Patient Book Schedule
     *
     * @param Request $request
     * @return Json
     */
    public function available_create_patient(Request $request)
    {
        $dentist_id = $request->input('dentist_id');
        $start = $request->input('start');
        $end = $request->input('end');

        // Always return true if dentist is self manager
        $dentist_info = User::find($dentist_id);
        if($dentist_info && $dentist_info->self_manager == true){
            return response()->json(['result' => true]);
        }

        // Judge available create book
        $criteria_start_date = (new \DateTime('@'.$start))->format('Y-m-d H:i:s');
        $criteria_end_date =(new \DateTime('@'.$end))->format('Y-m-d H:i:s');

        $schedule = Schedules::where('dentist_id', '=', $dentist_id)
            ->where('start', '<=', $criteria_start_date)
            ->where('end', '>=', $criteria_end_date)
            ->first();
        if(!empty($schedule)) {
            return response()->json(['result' => true]);
        } else {
            return response()->json(['result' => false]);
        }

    }

}
