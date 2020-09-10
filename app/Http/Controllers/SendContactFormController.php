<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactForm;

class SendContactFormController extends Controller
{
    function index()
    {
       return view('frontEnd.contact');
    }

    function send(Request $request)
    {
      $this->validate($request, [
        'email' => 'required|email',
        'message' => 'required'
      ]);
      $data = array(
        'name' => $request->name,
        'surname' => $request->surname,
        'message' => $request->message,
        'email' => $request->email
      );
      Mail::to('pedtrash@gmail.com')->send(new ContactForm($data)); #test purposes
      return back()->with('success', 'Thanks for contacting us!');
    }
}
