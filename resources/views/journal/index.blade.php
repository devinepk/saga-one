@extends('layout.page')

@section('page-title', 'My Journals')

@section('page-content')
<h1 class="mb-4">Your journals</h1>
@if (count($journals))
    <div class="row">

        @foreach($journals as $journal)
            <div class="col-md-6 col-lg-4">

                <journal-card
                    auth-user-json="{{ Auth::user() }}"
                    write-url="{{ Auth::user()->can('addEntry', $journal) ? route('journal.show', $journal) : '' }}"
                    read-url="{{ Auth::user()->can('view', $journal) ? route('journal.contents', $journal) : '' }}"
                    image-url="{{ Storage::url($journal->image_path) }}"
                    settings-url="{{ Auth::user()->can('viewSettings', $journal) ? route('journal.settings', $journal) : '' }}"
                    queue-json="{{ $journal->queue }}"
                    journal-json="{{ $journal }}"
                ></journal-card>

            </div>
        @endforeach
    </div>

@else

    <alert level="primary">
        You don't have any journals. <a class="alert-link" href="{{ route('journal.create') }}">Create one</a> and invite your friends!
    </alert>

@endif

@component('component.addButton')
    @slot('url', route('journal.create'))
    Create a new journal
@endcomponent

@endsection
