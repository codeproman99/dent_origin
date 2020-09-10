<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TrialForm;

class SendTrialFormController extends Controller
{
    function index()
    {
       return view('frontEnd.trial');
    }

    function send(Request $request)
    {
      $this->validate($request, [
        'name' => 'required',
        'surname' => 'required',
        'email' => 'required|email',
        'business_name' => 'required'
      ]);
      $data = array(
        'name' => $request->name,
        'surname' => $request->surname,
        'email' => $request->email,
        'business_name' => $request->business_name
      );
      Mail::to('pedtrash@gmail.com')->send(new TrialForm($data)); #test purposes
      return back()->with('success', 'Thanks for subscribing for the free trial!');
    }
}
