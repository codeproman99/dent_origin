<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\User;
use App\Patients;

class DentistController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user_id = Auth::user()->id;

        $dentists = User::where('role', 2)
            ->where('assigned_manager', $user_id)
            ->where('self_manager', 0)
            ->where('status', 1)
            ->get();

        $leads = array();

        foreach ($dentists as $d) {
            $leads[ $d->id ] = Patients::where('dentist_id' ,'=', $d->id)->count();
        }
        return view('dentists', ['dentists' => $dentists, 'total_leads' => $leads]);

    }

    /**
     *  Dentist management for assign Managers
     *
     * @return \Illuminate\View\View
     */
    public function management()
    {
        $dentists = User::where('role', 2)->where('self_manager', 0)->where('status', 1)->get();
        $managers = User::where('role', 3)->where('status', 1)->get();

        return view('dentists_management', ['dentists' => $dentists, 'managers' => $managers]);

    }

    /**
     * Assign Manager function
     *
     * @param Request $request
     * @return Json
     */
    public function assign_manager(Request $request)
    {
        $id = $request->input('id');
        $manager_id  = $request->input('manager_id');

        $dentist = User::find($id);

        if ($dentist) {
            $dentist->assigned_manager = $manager_id;
            $result = $dentist->save();
        }

        if ($result) {
            return response()->json(['success' => true, 'result' => $result]);
        } else {
            return response()->json(['success' => false]);
        }

    }
}
