@extends('layout.page')

@section('page-title', 'My Journals')

@section('page-content')

@if (count($journals))
    <div class="row">

        @foreach($journals as $journal)
            <div class="col-sm col-md-6 col-lg-4">

                <journal-card
                    auth-user-json="{{ Auth::user() }}"
                    write-url="{{ Auth::user()->can('addEntry', $journal) ? route('journal.show', $journal) : '' }}"
                    read-url="{{ Auth::user()->can('view', $journal) ? route('journal.contents', $journal) : '' }}"
                    image-url="{{ asset('/img/cover1.jpg') }}"
                    settings-url="{{ Auth::user()->can('update', $journal) ? route('journal.edit', $journal) : '' }}"
                    queue-json="{{ $journal->queue }}"
                    journal-json="{{ $journal }}"
                >
                </journal-card>

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
