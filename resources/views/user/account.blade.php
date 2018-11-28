@extends('layout.page')

@section('page-title', 'Account')

@section('page-content')
<h1 class="mt-5">Your account</h1>

@unless (Auth::user()->hasVerifiedEmail())
    <alert level="danger" :dismissible="false">
        <span>You have not yet verified your email address. Please check your email for a verification link. {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}" class="alert-link">{{ __('click here to request another') }}</a>.</span>
    </alert>
@endif

<div class="row my-5 justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <form class="card-body" method="post" action="{{ route('user.update') }}" id="account-form">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Name</label>
                    <input id="name" name="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ $errors->has('name') ? old('name') : Auth::user()->name }}">
                    @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="email">E-Mail Address</label>
                    <input id="email" name="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ $errors->has('email') ? old('email') : Auth::user()->email }}">
                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>

            </form>
            <button type="submit" class="btn btn-block btn-primary" form="account-form">Save account information</button>
        </div>
    </div>
</div>


<div class="row my-5 justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <h2 class="card-header">Change password</h2>
            <form class="card-body" method="post" action="{{ route('user.changePassword') }}" id="password-form">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="old_password">Current password</label>
                    <input id="old_password" name="old_password" type="password" class="form-control{{ $errors->has('old_password') ? ' is-invalid' : '' }}" required>
                    @if ($errors->has('old_password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('old_password') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="new_password">New password</label>
                    <input id="new_password" name="new_password" type="password" class="form-control{{ $errors->has('new_password') ? ' is-invalid' : '' }}" required>
                    @if ($errors->has('new_password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('new_password') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="new_password_confirmation">Confirm new password</label>
                    <input id="new_password_confirmation" name="new_password_confirmation" type="password" class="form-control{{ $errors->has('new_password_confirmation') ? ' is-invalid' : '' }}" required>
                    @if ($errors->has('new_password_confirmation'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('new_password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>

            </form>
            <button type="submit" class="btn btn-block btn-primary" form="password-form">Change password</button>
        </div>
    </div>
</div>
@endsection
