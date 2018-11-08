@extends('layout.journal')

@section('page-title', "Entries in {$journal->title}")

@section('journal-content')
<div class="container">


    @if (count($entries))

    <h1>{{ $journal->title }}: All Entries</h1>

    @component('component.addButton')
        @slot('url', route('journal.add', $journal))
        Add a new entry
    @endcomponent

    {{ $entries->links() }}

        @foreach ($entries as $entry)
            <entry-card
                title="{{ $entry->title }}"
                title-url="{{ route('entry.show', $entry) }}"
                author="{{ $entry->author->name }}"
                updated-at="{{ $entry->formatted_updated_at }}"
            >
                {!! $entry->excerpt !!}
            </entry-card>
        @endforeach

    @else
        <div class="alert alert-info">The are no entries in this journal. Time to get writing!</div>

        @component('component.addButton')
            @slot('url', route('journal.add', $journal))
            Add a new entry
        @endcomponent

    @endif

</div>
@endsection
