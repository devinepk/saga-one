@extends('layout.page')

@section('page-title', 'My Journals')

@section('page-content')
<h1 class="mb-4">Your journals</h1>
@if (count($journals))
    <div class="row">

        @foreach($journals as $journal)
            <div class="col-sm col-md-6 col-lg-4">

                <journal-card
                    auth-user-json="{{ Auth::user() }}"
                    write-url="{{ Auth::user()->can('addEntry', $journal) ? route('journal.show', $journal) : '' }}"
                    read-url="{{ Auth::user()->can('view', $journal) ? route('journal.contents', $journal) : '' }}"
                    image-url="{{ asset('/img/cover1.jpg') }}"
                    settings-url="{{ Auth::user()->can('viewSettings', $journal) ? route('journal.settings', $journal) : '' }}"
                    queue-json="{{ $journal->queue }}"
                    journal-json="{{ $journal }}"
                >
                </journal-card>

            </div>
        @endforeach
    </div>

@else

    <div class="alert alert-info">You don't have any journals. <a href="{{ route('journal.create') }}'">Create one</a> and invite your friends!</div>

@endif

@component('component.addButton')
    @slot('url', route('journal.create'))
    Create a new journal
@endcomponent

@endsection
