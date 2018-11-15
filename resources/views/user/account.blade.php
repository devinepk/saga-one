@extends('layout.page')

@section('page-title', 'Account')

@section('page-content')
<h1 class="mt-5">Your account</h1>

@unless (Auth::user()->hasVerifiedEmail())
    <alert level="danger" :dismissible="false">
        <p>You have not yet verified your email address. Please check your email for a verification link.</p>
        <p>{{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}" class="alert-link">{{ __('click here to request another') }}</a>.</p>
    </alert>
@endif

<div class="row mt-5">
    <div class="col-md-4">
        <div class="card mb-5">
            <img class="card-img-top">
                <button class="btn btn-secondary">Upload profile picture</button>
        </div>
    </div>
    <div class="col-md">
        <form class="container" method="post" action="{{ route('user.update') }}">
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
                <label for="email">Email</label>
                <input id="email" name="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ $errors->has('email') ? old('email') : Auth::user()->email }}">
                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Update profile</button>
        </form>
    </div>
</div>
@endsection
