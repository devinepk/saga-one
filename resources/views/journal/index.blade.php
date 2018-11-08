@extends('layout.page')

@section('page-title', 'My Journals')

@section('page-content')

{{-- CURRENT JOURNALS --}}
@if (Auth::user()->current_journals->count())
    <h2 class="mt-5">Journals you can write in</h2>
    <div class="row">
        @foreach(Auth::user()->current_journals as $journal)
            <div class="col-sm col-md-6 col-lg-4">
                <div class="card journal-card border-0 mb-5">

                    <journal-card-body
                        description="{{ $journal->description }}"
                        show-url="{{ route('journal.show', $journal) }}"
                        contents-url="{{ route('journal.contents', $journal) }}"
                        image-url="{{ asset('/img/cover1.jpg') }}"
                        invite-url="{{ Auth::user()->can('invite', $journal) ? route('journal.invite', $journal) : '' }}"
                        edit-url="{{ Auth::user()->can('update', $journal) ? route('journal.edit', $journal) : '' }}"
                        archive-url="{{ Auth::user()->can('archive', $journal) ? route('journal.archive', $journal) : '' }}"
                    >
                        <template>{{ $journal->title }}</template>
                    </journal-card-body>

                    @if ($journal->users->count() > 1)

                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><h5 class="m-0">Journal queue:</h5></li>
                            @include('component.queue')
                        </ul>

                        <div class="card-footer">
                        @if (Auth::id() == $journal->current_user->id)
                            <small>You've got this journal right now. What will you write?</small>
                        @else
                            <small class="text-muted">{{ $journal->current_user->name }} has this journal right now.</small>
                        @endif
                        </div>

                    @elseif (Auth::id() == $journal->creator->id)

                        <div class="card-footer">
                            <small>The real magic begins when you share this journal with others. <a href="/journal/invite">Invite a friend</a> now!</small>
                        </div>

                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endif

{{-- OTHER JOURNALS --}}
@if (Auth::user()->other_journals->count())
    <h2 class="mt-5">Other Journals</h2>
    <div class="row">

    @foreach (Auth::user()->other_journals as $journal)
        <div class="col-sm col-lg-4">
            <div class="card journal-card border-0 mb-5">
                <journal-card-body
                        description="{{ $journal->description }}"
                        image-url="{{ asset('/img/cover1.jpg') }}"
                        invite-url="{{ Auth::user()->can('invite', $journal) ? route('journal.invite', $journal) : '' }}"
                        edit-url="{{ Auth::user()->can('update', $journal) ? route('journal.edit', $journal) : '' }}"
                        archive-url="{{ Auth::user()->can('invite', $journal) ? route('journal.invite', $journal) : '' }}"
                    >
                        <template>{{ $journal->title }}</template>
                    </journal-card-body>

                @if ($journal->users->count() > 1)

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><h5 class="m-0">Journal queue:</h5></li>
                        @foreach ($journal->queue as $user)
                            <li class="list-group-item"><font-awesome-icon icon="user"></font-awesome-icon><span class="ml-2">{{ $user->name }}</span></li>
                        @endforeach
                    </ul>

                    <div class="card-footer">
                        <small class="text-muted">{{ $journal->current_user->name }} has this journal right now.</small>
                    </div>

                @elseif (Auth::id() == $journal->creator->id)

                    <div class="card-footer">
                        <span>The real magic begins when you share this journal with others. <a href="/journal/invite">Invite a friend</a> now!</span>
                    </div>

                @endif
            </div>
        </div>
    @endforeach
    </div>
@endif


{{-- ARCHIVED JOURNALS --}}
@if (Auth::user()->journals()->where('active', 'false')->count())
    <h2>Archived journals</h2>
    <p>Archived journals are "sealed" and can't be written in or edited in any way. They are also removed from rotation, which means everyone in the journal will be able to read it anytime.</p>
    <div class="row">
        @foreach(Auth::user()->journals()->where('active', 'false')->get() as $journal)
            <div class="col-sm col-md-6 col-lg-4">
                <div class="card journal-card border-0 mb-5">

                    <journal-card-body
                        description="{{ $journal->description }}"
                        contents-url="{{ route('journal.contents', $journal) }}"
                        image-url="{{ asset('/img/cover1.jpg') }}"
                    >
                        <template>{{ $journal->title }}</template>
                    </journal-card-body>

                    @if ($journal->users->count() > 1)

                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><h5 class="m-0">Journal queue:</h5></li>
                            @include('component.queue')
                        </ul>

                    @elseif (Auth::id() == $journal->creator->id)

                        <div class="card-footer">
                            <small>There are no other users in this journal.</small>
                        </div>

                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endif

{{-- NO JOURNALS --}}
@if (!Auth::user()->journals->count())
    <div class="alert alert-info">You don't have any journals. <a href="{{ route('journal.create') }}'">Create one</a> and invite your friends!</div>
@endif

<a class="btn btn-block btn-primary py-3 mb-5" href="/journal/create"><font-awesome-icon icon="plus"></font-awesome-icon></a>
@endsection
