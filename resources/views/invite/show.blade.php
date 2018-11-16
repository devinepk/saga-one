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

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card my-5">
                <h2 class="card-header">{{ Auth::user()->name }}, do you want to join {{ $invite->journal->title }}?</h2>
                <div class="card-body">
                    <p><strong>{{ $invite->sender->name }}</strong> has invited you to join <strong>{{ $invite->journal->title }}</strong>.<p>
                    <p>If you accept this invitation, you will be able to read and write in this journal when it is your turn. The other participants in the journal will be able to read your posts and make comments.</p>

                    <p>To accept this invitation and add this journal to your account, click "Accept and Join" below.</p>
                </div>
                <form method="post" action="{{ route('invite.accept', $invite) }}" class="card-footer p-0">
                    @csrf
                    <div class="row no-gutters">
                        <div class="col-4">
                            <a href="{{ route('invite.decline', $invite) }}" class="btn btn-block">Decline</a>
                        </div>
                        <div class="col">
                            <button type="submit" class="btn btn-block btn-secondary"><strong>Accept and Join</strong></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


</div>
@endsection
