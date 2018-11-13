<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InviteController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Invite Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling the verification of journal
    | invites.
    |
    */

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = '/journal';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function verify() {
        return 'Let me verify that invitation...';
    }
}
