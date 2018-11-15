<?php

namespace App\Http\Controllers;

use App\User;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function account(Request $request)
    {
        return view('user.account');
    }

    /**
     * Update the user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $messages = [
            'name.required' => 'Please provide a :attribute.',
            'email.required' => 'Please provide an :attribute.',
            'max' => 'Your :attribute may not be longer than :max characters.'
        ];
        $rules = [
            'name' => 'required|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore(Auth::id())
            ]
        ];

        $validator = Validator::make($request->only('name', 'email'), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->route('user.account')
                        ->withErrors($validator)
                        ->withInput();
        }

        $emailFlash = '';

        if (Auth::user()->email != $request->email) {
            Auth::user()->email = $request->email;
            Auth::user()->email_verified_at = null;
            Auth::user()->sendEmailVerificationNotification();

            $emailFlash = " Please check your email for a verification link.";
        }

        Auth::user()->name = $request->name;
        Auth::user()->save();

        return redirect()->route('user.account')
            ->with('status', "Your information has been updated." . $emailFlash);

    }
}
