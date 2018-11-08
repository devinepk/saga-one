@extends('layout.journal')

@section('page-title', "Entries in {$journal->title}")

@section('journal-content')
<div class="container p-md-5">
    @component('component.addButton')
        @slot('url', route('entry.create', $journal))
        Add a new entry
    @endcomponent

    @if (count($entries))

    <h1>{{ $journal->title }}: All Entries</h1>
    {{ $entries->links() }}

        @foreach ($entries as $entry)
            <entry-card
                title="{{ $entry->title }}"
                read-url="{{ route('entry.show', ['journal' => $journal, 'entry' => $entry]) }}"
                author="{{ $entry->author->name }}"
                updated-at="{{ $entry->formatted_updated_at }}"
            >
                {!! $entry->excerpt !!}
            </entry-card>
        @endforeach

    @else
        <div class="alert alert-info">The are no entries in this journal. Time to get writing!</div>
    @endif

</div>
@endsection
