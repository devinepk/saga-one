@extends('layout.journal')

@section('page-title', "Journal Settings")

@section('journal-content')
<div class="container">
    @if (session('resent'))
        <alert>{{ __('A fresh verification link has been sent to your email address.') }}</alert>
    @endif

    <h1>{{ $journal->title }} Settings</h1>

    @if (!$journal->active)
        <alert level="primary" :dismissible="false">
            <h4>This journal has been archived.</h4>
            <p>Archived journals are "sealed" and can no longer be written in. They are also removed from rotation, which means everyone in the journal can read it anytime.</p>
        </alert>
    @endif

    @can('update', $journal)
        <div class="card my-5">
            <h2 class="card-header">General settings</h2>
            <div class="card-body">
                <form id="update-form" method="post" action="{{ route('journal.update', $journal) }}">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" id="title" name="title" value="{{ $errors->has('title') ? old('title') : $journal->title }}">
                        @if ($errors->has('title'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" id="description" name="description" value="{{ $errors->has('description') ? old('description') : $journal->description }}">
                        @if ($errors->has('description'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                        @endif
                    </div>
                </form>
            </div>
            <button type="submit" form="update-form" class="btn btn-block btn-primary">Save</button>
        </div>
    @endcan


        <div class="card mb-5">
            <h2 class="card-header">Participants</h2>
            <table class="table table-hover border-bottom mb-0">
                <thead>
                    <tr><th class="border-top-0 border-dark">Name</th><th class="border-top-0 border-dark">Status</th></tr>
                </thead>
                <tbody>
                    @foreach ($journal->users as $user)
                        <tr>
                            <td>
                                {{ $user->name }}
                                @if (Auth::id() == $user->id) (you) @endif
                            </td>
                            <td>Joined {{ $user->subscription->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="card-body">
                <h4>Invite someone to join this journal</h4>
                @can('invite', $journal)
                    <form method="post" action="{{ route('journal.invite', $journal) }}" class="form-inline">
                        @csrf
                        <label for="name" class="sr-only">Name</label>
                        <input type="name" class="form-control mb-1 mr-2" size="25" id="name" name="name" placeholder="Name" required>
                        @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                        <label for="email" class="sr-only">Email address</label>
                        <input type="email" class="form-control mb-1 mr-2" size="25" id="email" name="email" placeholder="Email" required>
                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                        <button type="submit" class="btn btn-primary mb-1">Invite</button>
                    </form>
                @else
                    <alert level="danger" :dismissible="false" class="mb-0">

                        <p>Only verified users can invite others to join a journal. You have not yet verified your email address.</p>
                        <p>Please check your email for a verification link. {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}" class="alert-link">{{ __('click here to request another') }}</a>.</p>

                    </alert>
                @endcan
            </div>
        </div>



    @can('archive', $journal)
        <div class="card mb-5">
            <h2 class="card-header">{{ $journal->active ? 'Archive' : 'Unarchive' }} this journal</h2>
            <div class="card-body">
                @if ($journal->active)
                    <p>Archived journals are "sealed" and can no longer be written in. Entries can't be added or edited, nor can new comments be posted. They are also removed from rotation, which means everyone in the journal will be able to read it anytime.</p>
                    <p><strong>Consider informing the other participants of this journal before archiving it.</strong></p>

                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#archive-confirm">
                        <font-awesome-icon icon="archive"></font-awesome-icon>
                        <span class="ml-2">Archive this journal</span>
                    </button>

                    <modal modal-id="archive-confirm">
                        <template slot="title">Are you sure you want to archive this journal?</template>
                        <p>This will remove the journal from the current user's possession <strong>without</strong> posting any of their draft entries.</p>
                        <p>You may want to give a heads up to the other participants in this journal first!</p>
                        <template slot="footer">
                            <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                            <form class="d-inline" method="post" action="{{ route('journal.archive', $journal) }}">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-danger">Yes, archive</button>
                            </form>
                        </template>
                    </modal>
                @else
                    <p>Unarchive this journal to put it back into rotation. You will be the first person to have it, and the rotation will proceed according to the queue.</p>
                    <form class="d-inline" method="post" action="{{ route('journal.archive', $journal) }}">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-dark">Unarchive this journal</button>
                    </form>
                @endif
            </div>
        </div>
    @endcan

</div>
@endsection
