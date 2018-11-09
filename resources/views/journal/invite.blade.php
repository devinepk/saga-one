@extends('layout.journal')

@section('page-title', 'Invite a friend')

@section('journal-content')
<div class="container">
    <h1>Invite a friend to join <strong>{{ $journal->title }}</strong></h1>
    @if ($journal->description)
        <p class="font-italic">{{ $journal->description }}</p>
    @endif

    <form method="post" action="{{ route('journal.processInvite', $journal) }}">
        @csrf
        <div class="form-group my-5">
            <label for="name">Name:</label>
            <input type="name" class="form-control" id="name" name="name" required autofocus>
            @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group my-5">
            <label for="email">Email address:</label>
            <input type="email" class="form-control" id="email" name="email" required>
            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group my-5">
            <button type="submit" class="btn btn-block btn-primary">Invite</button>
        </div>
    </form>
</div>
@endsection
