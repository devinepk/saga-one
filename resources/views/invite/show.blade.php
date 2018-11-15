@extends('layout.journal')

@section('page-title', "Join a journal")

@section('journal-content')
<div class="container">

    <journal-card
        class="d-md-none my-3"
        auth-user-json="{{ Auth::user() }}"
        image-url="{{ asset('/img/cover1.jpg') }}"
        queue-json="{{ $invite->journal->queue }}"
        journal-json="{{ $invite->journal }}"
    ></journal-card>

    <div class="card mb-5">
        <h2 class="card-header">{{ Auth::user()->name }}, do you want to join {{ $invite->journal->title }}?</h2>
        <div class="card-body">
            <p><strong>{{ $invite->sender->name }}</strong> has invited you to join <strong>{{ $invite->journal->title }}</strong>.<p>
            <p>To accept this invitation and add this journal to your account, click "Accept and Join" below.</p>
        </div>
        <form method="post" action="{{ route('invite.accept', $invite) }}">
            @csrf
            <div class="row no-gutters">
                <div class="col">
                    <a href="{{ route('invite.decline', $invite) }}" class="btn btn-block btn-dark">Decline</a>
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-block btn-secondary"><strong>Accept and Join</strong></button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
