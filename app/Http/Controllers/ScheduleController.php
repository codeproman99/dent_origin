<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Schedules;

class ScheduleController extends Controller
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
     * Create new Schedule
     *
     * @param Illuminate\Http\Request
     *
     * @return Json
     */

    public function create(Request $request)
    {
        $data = $request->all();
        $title = $data['title'];
        $dentist_id = $data['dentist_id'];
        $calendar_id = $data['id'];
        $start = $data['start'];
        $end = $data['end'];

        $result = Schedules::create([
            'title' => $title,
            'dentist_id' => $dentist_id,
            'calendar_id' => $calendar_id,
            'start' => $start,
            'end' => $end
        ]);

        return response()->json(['result' => true]);

    }

    /**
     * Update Schedule
     *
     * @param Illuminate\Http\Request
     *
     * @return Json
     */
    public function update(Request $request)
    {
        $data = $request->all();

        $id = $data['id'];
        $schedule = Schedules::where('calendar_id', '=', $id)->first();

        if( $schedule ){
            $schedule->title = $data['title'];
            $schedule->dentist_id = $data['dentist_id'];
            $schedule->start = $data['start'];
            $schedule->end = $data['end'];
            $result = $schedule->save();
        } else {
            $result = ['success'=>'failed'];
        }

        return response()->json(['result' => $result]);
    }

    /**
     * Delete Schedule by ID
     *
     * @param Illuminate\Http\Request
     *
     * @return Json
     */
    public function delete(Request $request)
    {
        $id = $request->input('id');

        $schedule = Schedules::where('calendar_id', '=', $id);

        if( $schedule ){
            $result = $schedule->delete();
        } else {
            $result = ['success' => 'failed'];
        }

        return response()->json(['result' => $result]);

    }


}
