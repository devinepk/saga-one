@extends('layout.page')

@section('page-title', "Pending Invites")

@section('page-content')
    <h1 class="mb-4">Your invites</h1>

    <div class="row">

        <div class="col-lg">
            <div class="card mb-4">
                <h2 class="card-header">Pending invites</h2>
                <div class="card-body">
                    @if(count($pending_invites))
                        <table class="table">
                            <thead>
                                <tr><th>Journal</th><th>Sender</th><th>Date sent</th></tr>
                            </thead>
                            <tbody>
                                @foreach ($pending_invites as $invite)
                                    <journal-card
                                        auth-user-json="{{ Auth::user() }}"
                                        image-url="{{ asset('/img/cover1.jpg') }}"
                                        queue-json="{{ $invite->journal->queue }}"
                                        journal-json="{{ $invite->journal }}"
                                    ></journal-card>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>You don't have any pending invites as this time.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg">
            <div class="card mb-4">
                <h2 class="card-header">Accepted invites</h2>
                @if(count($accepted_invites))
                    <div class="table-responsive">
                        <table class="table table-hover text-nowrap mb-0">
                            <thead>
                                <tr><th>Journal</th><th>Sender</th><th>Date sent</th></tr>
                            </thead>
                            <tbody>
                                @foreach ($accepted_invites as $invite)
                                    <tr>
                                        <td>{{ $invite->journal->title }}</td>
                                        <td>{{ $invite->sender->name }}</td>
                                        <td>{{ $invite->updated_at }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p>You haven't accepted any invites yet.</p>
                @endif
            </div>
        </div>

        <div class="col-lg">
            <div class="card mb-4">
                <h2 class="card-header">Declined invites</h2>
                <div class="card-body">
                    @if(count($declined_invites))
                        <table class="table">
                            <thead>
                                <tr><th>Journal</th><th>Sender</th><th>Date sent</th></tr>
                            </thead>
                            <tbody>
                                @foreach ($declined_invites as $invite)
                                    <tr>
                                        <td>{{ $invite->journal->title }}</td>
                                        <td>{{ $invite->sender->name }}</td>
                                        <td>{{ $invite->updated_at }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>You haven't declined any invites.</p>
                    @endif
                </div>
            </div>
        </div>

    </div>
@endsection
