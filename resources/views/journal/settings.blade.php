@extends('layout.journal')

@section('page-title', "Journal Settings")

@section('journal-content')
<div class="container">
    <h1 class="mb-5">{{ $journal->title }}</h1>

    @if (Auth::user()->can('update', $journal))
        <div class="card mb-5">
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
    @endif


    @if (Auth::user()->can('invite', $journal))
        <div class="card mb-5">
            <h2 class="card-header">Participants</h2>

            <table class="table table-hover border-bottom mb-0">
                <thead>
                    <tr><th class="border-top-0">Name</th><th class="border-top-0">Status</th></tr>
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
                <h3>Invite someone to join this journal</h3>

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
            </div>
        </div>
    @endif


    @if (Auth::user()->can('archive', $journal))
        <div class="card mb-5">
            <h2 class="card-header">Archive this journal</h2>
            <div class="card-body">

                <p>Archived journals are "sealed" and can no longer be written in.</p>

                <p>They are also removed from rotation, which means everyone in the journal will be able to read it anytime.</p>

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
            </div>
        </div>
    @endif

</div>
@endsection
