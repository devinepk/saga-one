@extends('emails.layout')

@section('body')
    @component('emails.components.h1')
        Welcome to SagaOne, {{ $user->name }}!
    @endcomponent

    @component('emails.components.p')
        SagaOne is a communal journal app that enables you to share your life with a small group of friends.
    @endcomponent

    @component('emails.components.p')
        To get started, log in and <a href="{{ route('journal.create') }}" style="color: #3869D4;">create a journal</a>!
    @endcomponent

    @component('emails.components.p')
        Happy writing!
    @endcomponent
@endsection
