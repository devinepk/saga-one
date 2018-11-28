<?php

namespace App\Http\Controllers;

use App\User;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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

    /**
     * Change the user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|max:255',
            'new_password' => 'required|confirmed|different:old_password|min:6|max:255',
        ]);

        $user = Auth::user();

        // Validate the old password
        if (Hash::check($request->old_password, $user->password)) {
            // Validate the new password

            $user->password = Hash::make($request->new_password);
            $user->save();

            return redirect()->route('user.account')
                ->with('status', "Your password has been changed.");
        }

        // Cf. Illuminate\Foundation\Auth\AuthenticatesUsers::sendFailedLoginResponse()
        throw ValidationException::withMessages([
            'old_password' => [trans('auth.failed')],
        ]);
    }
}
