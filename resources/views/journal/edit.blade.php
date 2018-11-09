@extends('layout.journal')

@section('page-title', "Edit {$journal->title}")

@section('journal-content')
<div class="container">
    <h1>Update journal details</h1>

    <nav class="nav my-3">
        @if (Auth::user()->can('invite', $journal))
            <a class="nav-link py-1" href="{{ route('journal.invite', $journal) }}">
                <font-awesome-icon icon="user-plus"></font-awesome-icon>
                <span class="ml-2">Invite</span>
            </a>
        @endif

        @if (Auth::user()->can('update', $journal))
            <a class="nav-link py-1" href="{{ route('journal.edit', $journal) }}">
                <font-awesome-icon icon="edit"></font-awesome-icon>
                <span class="ml-2">Edit</span>
            </a>
        @endif

        @if (Auth::user()->can('archive', $journal))
            <button type="button" class="btn btn-link nav-link border-0 text-left py-1" data-toggle="modal" data-target="#archive-confirm">
                <font-awesome-icon icon="archive"></font-awesome-icon>
                <span class="ml-2">Archive</span>
            </button>

            <modal modal-id="archive-confirm-{{ Illuminate\Support\Str::uuid() }}">
                <template slot="title">Archive this journal?</template>
                <p>Archived journals are "sealed" and can no longer be written in or edited in any way.</p>
                <p>They are also removed from rotation, which means everyone in the journal will be able to read it anytime.</p>
                <p>Are you sure you want to archive this journal?</p>
                <template slot="footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    <form class="d-inline" method="post" action="{{ route('journal.archive', $journal) }}">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-danger">Yes, archive</button>
                    </form>
                </template>
            </modal>
        @endif
    </nav>

    <form method="post" action="{{ route('journal.update', $journal) }}">
        @method('PUT')
        @csrf

        <div class="form-group my-5">
            <label for="title">Change this journal's title:</label>
            <input class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" id="title" name="title" value="{{ $errors->has('title') ? old('title') : $journal->title }}">
            @if ($errors->has('title'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('title') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group my-5">
            <label for="description">Change this journal's description:</label>
            <input type="text" class="form-control" id="description" name="description" value="{{ $journal->description }}">
        </div>

        <div class="row pt-3">
            <div class="col-4">
                <a class="btn btn-block" href="{{ route('journal.show', $journal) }}">Cancel</a>
            </div>
            <div class="col">
                <button type="submit" class="btn btn-block btn-primary">Update</button>
            </div>
        </div>

    </form>
</div>
@endsection
