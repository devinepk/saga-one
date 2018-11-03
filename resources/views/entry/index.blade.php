@extends('layout.journal')

@section('page-title', "Entries in {$journal->title}")

@section('journal-content')
<div class="container p-md-5">

    @if ($journal->entries()->count())
    <h1>Entries in {{ $journal->title }}</h1>
        @foreach ($journal->entries as $entry)
            <entry-card
                title="{{ $entry->title }}"
                edit-url="{{ route('entry.edit', $entry) }}"
                read-url="{{ route('entry.show', $entry) }}"
                author="{{ $entry->author->name }}"
                author-url="#"
                created-on="{{ $entry->created_at }}"
            >
                {!! $entry->excerpt !!}
            </entry-card>
        @endforeach

    @else
    <div class="alert alert-info">The are no entries in this journal. Time to get writing!</div>
    @endif

</div>
@endsection
