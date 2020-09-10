<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;

class HomeController extends Controller
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
     * Redirect User's Main Page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Define Redirections

        $user_role = Auth::user()->role;

        switch ($user_role) {
            case '1':
                return redirect()->route('users');
                break;
            case '2':
                return redirect()->route('calendar');
                break;
            case '3':
                return redirect()->route('dentists');
                break;
            default:
                return redirect()->route('calendar');
                break;
        }


    }
}
