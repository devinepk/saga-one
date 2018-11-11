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
    public function update(Request $request, User $user)
    {
        if (Auth::id() == $user->id) {
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
                    Rule::unique('users')->ignore($user->id)
                ]
            ];

            $validator = Validator::make($request->only('name', 'email'), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->route('user.account')
                            ->withErrors($validator)
                            ->withInput();
            }

            $emailFlash = '';
            if ($user->email != $request->email) {
                $user->email = $request->email;
                $user->email_verified_at = null;
                $user->sendEmailVerificationNotification();

                $emailFlash = " Please check your email for a verification link.";
            }

            $user->name = $request->name;
            $user->save();

            $request->session()->flash('status', "Your information has been updated." . $emailFlash);
            return redirect()->route('user.account');
        }

        // Redirect to journal index
        return redirect()->route('journal.index');
    }
}
