@extends('emails.layout')

@section('body')
<h1>Nice to meet you, {{ $user->name }}!</h1>

<p>Thank you for registering for SagaOne! Please click the button below to verify your email address.</p>

@component('emails.button')
    @slot('url', $verificationUrl)
    Verify Email Address
@endcomponent

<p>If you did not create an account, you may disregard this email.</p>

@endsection
