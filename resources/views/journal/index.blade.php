@extends('layout.journal')

@section('page-title', $journal['title'])

@section('journal-content')
<div class="container p-md-5">
    <h1>{{ $journal['title'] }}</h1>
    <p class="font-italic">{{ $journal['description'] }}</p>
    @if ($journal['participantCount'])
        <p>Shared with {{ $journal['participantCount'] }} friends.</p>
    @endif

    <h2>Latest entries</h2>
    @foreach ($entries as $entry)
        <entry-card
            title="{{ $entry['title'] }}"
            edit-url="/journal/write"
            read-url="/journal/read"
            author="{{ $entry['author'] }}"
            author-url="#"
            created-on="{{ $entry['created'] }}"
        >
            {!! $entry['excerpt'] !!}
        </entry-card>
    @endforeach

    <a href="/journal/contents">View all entries</a>
</div>
@endsection
