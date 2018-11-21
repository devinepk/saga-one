@extends('emails.layout')

@section('body')
<h1>Welcome to SagaOne, {{ $user->name }}!</h1>

<p>SagaOne is a communal journal app that enables you to share your life with a small group of friends.</p>

<p>To get started, log in and <a href="{{ route('journal.create') }}">create a journal</a>!</p>

<p>Happy writing!<p>
@endsection
