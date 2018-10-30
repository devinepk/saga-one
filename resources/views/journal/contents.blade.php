@extends('layout.journal')

@section('page-title', $journal['title'])

@section('journal-content')
<div class="container p-md-5">
    <h1>Entries in {{ $journal['title'] }}</h1>
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
</div>
@endsection
