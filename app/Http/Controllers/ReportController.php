<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\User;
use App\Reports;
use App\Patients;
use Validator;
class ReportController extends Controller
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
     * Show the Report Information
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $current_year = date('Y');
        $current_month = date('m');

        $report = Reports::where('dentist_id', '=', $user_id)
            ->where('year', '=', $current_year)
            ->where('month' ,'=' , (int)$current_month)->first();

        if( $report ){
            $report_data = $this->calc( $user_id, $current_year, $current_month, $report->flat_price_month, $report->rate_month);
        } else {
            $report_data = $this->calc( $user_id, $current_year, $current_month );
        }

        $years = $this->get_all_years( $user_id );
        if(empty($years)){
            $years = array($current_year);
        }
        $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "Novemeber", "December");

        return view('reports', ['dentist_id' => $user_id, 'current_year' => $current_year, 'years' => $years, 'months' => $months, 'current_month' => $current_month, 'report_data' => $report_data, 'report' => $report]);
    }


    /**
     * Dentist Report Page - from Manager
     *
     * @param [int] $id
     * @return View
     */
    public function report($id)
    {
        // userID === Dentist IDs
        $user_id = $id;
        $current_year = date('Y');
        $current_month = date('m');

        $user_info = User::where('id', '=', $user_id)->first();

        $report = Reports::where('dentist_id', '=', $user_id)
            ->where('year', '=', $current_year)
            ->where('month' ,'=' , (int)$current_month)->first();

        if( $report ){
            $report_data = $this->calc( $user_id, $current_year, $current_month, $report->flat_price_month, $report->rate_month);
        } else {
            $report_data = $this->calc( $user_id, $current_year, $current_month );
        }

        $years = $this->get_all_years( $user_id );
        if(empty($years)){
            $years = array($current_year);
        }
        $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "Novemeber", "December");

        return view('reports', ['dentist_id' => $user_id, 'user_info' => $user_info, 'current_year' => $current_year, 'years' => $years, 'months' => $months, 'current_month' => $current_month, 'report_data' => $report_data, 'report' => $report]);
    }

    /**
     *  Save Report Data
     *
     * @param Illuminate\Http\Request;
     *
     * @return Json
     */
    public function update(Request $request)
    {
        $data = $request->all();
        $user_id = $data['dentist_id'];
        $year = $data['year'];
        $month = $data['month'];
        $flat_price_month = $data['flat_price_month'];
        $rate_month = $data['rate_month'];

        $validator = Validator::make($request->all(), [
            'year' => 'required',
            'month' => 'required',
            'flat_price_month' => 'required|numeric',
            'rate_month' => 'required|numeric',
        ]);

        if ($validator->passes()) {
            $report = Reports::where('dentist_id', '=', $user_id)
                ->where('year', '=', $year)
                ->where('month', '=', $month)->first();

            if( $report ){
                $report->flat_price_month = $flat_price_month;
                $report->rate_month = $rate_month;
                $report->save();
            } else {
                $result = Reports::create([
                    'dentist_id' => $user_id,
                    'year' => $year,
                    'month' => $month,
                    'flat_price_month' => $flat_price_month,
                    'rate_month' =>$rate_month
                ]);
            }

            $report_data = $this->calc($user_id, $year, $month, $flat_price_month, $rate_month);
            return response()->json(['result' => $report_data]);
        }

        return response()->json(['error'=>$validator->errors()->all()]);

    }


    public function get_report_data(Request $request)
    {
        $data = $request->all();
        $user_id = $data['dentist_id'];
        $year = $data['year'];
        $month = $data['month'];

        $report = Reports::where('dentist_id', '=', $user_id)
            ->where('year', '=', $year)
            ->where('month', '=', $month)->first();

        if( $report ){
            $report_data = $this->calc( $user_id, $year, $month, $report->flat_price_month, $report->rate_month);
        } else {
            $report_data = $this->calc( $user_id, $year, $month );
        }

        return response()->json(['result' => $report_data]);
    }

    /**
     * Get all years from patients
     *
     * @param [int] $id
     * @return [Array] $years
     */
    private function get_all_years($id)
    {
        $user_id = $id;
        $years = array();
        $patients = Patients::where('dentist_id', '=', $user_id)->orderby('first_visit_start')->get();
        foreach( $patients as $p ){
            $year = $p->first_visit_start->format('Y');
            if( !in_array($year, $years) ){
                $years[] = $year;
            }
        }

        return $years;

    }

    /**
     *
     *  Get Report result with base data
     *
     * @param $year, $month, $flat_price_month, $rate_month
     *
     * @return Array
     */
    private function calc($id, $year = null, $month =  null, $flat_price_month = null, $rate_month = null)
    {
        $user_id = $id;
        $result = array();

        if( empty($year) || empty($month) ){
            return $result;
        }

        if( $month == 'all' ){
            $criteria_start_date = $year.'-01-01 00:00:00';
            $criteria_end_date = $year.'-12-31 23:59:59';
        } else {
            $criteria_start_date = $year.'-'.$month.'-01 00:00:00';
            $criteria_end_date = $year.'-'.$month.'-31 23:59:59';
        }

        $patients = Patients::where('dentist_id', '=', $user_id)
            ->where('first_visit_start', '>=', $criteria_start_date)
            ->where('first_visit_start', '<', $criteria_end_date)->get();


        $total_count = count($patients);

        $visited_patients = 0;
        $cancelled_visits = 0;
        $quotations_given = 0;
        $accepted_quotation = 0;
        $not_accepted_quotation = 0;
        $total_accepted_quotation_amount = 0;

        foreach($patients as $p){
            if( $p->visit_status == 1 ) $visited_patients++;
            if( $p->visit_status == 2 ) $cancelled_visits++;
            if( $p->quotation_status == 1 ) $quotations_given++;
            if( $p->quotation_status == 2 ) $accepted_quotation++;
            if( $p->quotation_status != 2 ) $not_accepted_quotation++;
            if( $p->quotation_status == 2 && !empty($p->total_accepted_quotation) ) $total_accepted_quotation_amount += $p->total_accepted_quotation;
        }

        // Flat Price

        $gaining = 0;
        $calculated_gainging = 0;
        $roi = 0;
        $roi_percent = 0;
        $total_investment = 0;

        if( !empty($flat_price_month) && !empty($rate_month) ){
            $gaining = $total_accepted_quotation_amount;
            $calculated_gainging = round($gaining * $rate_month / 100, 2);
            $roi = $gaining - ($flat_price_month + $calculated_gainging);
            $total_investment = $flat_price_month + $calculated_gainging;
            $roi_percent = round($roi / $flat_price_month * 100, 2);
        }

         $result = [
            'total_count'                     => $total_count,
            'visited_patients'                => $visited_patients,
            'cancelled_visits'                => $cancelled_visits,
            'quotations_given'                => $quotations_given,
            'accepted_quotation'              => $accepted_quotation,
            'not_accepted_quotation'          => $not_accepted_quotation,
            'total_accepted_quotation_amount' => $total_accepted_quotation_amount,
            'gaining'                         => $gaining,
            'calculated_gaining'              => $calculated_gainging,
            'roi'                             => $roi,
            'roi_percent'                     => $roi_percent,
            'total_investment'                => $total_investment,
            'flat_price_month'                => $flat_price_month,
            'rate_month'                      => $rate_month
        ];

        return $result;

    }


}
