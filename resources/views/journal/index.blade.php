@extends('layout.journal')

@section('page-title', $journal['title'])

@section('journal-content')
<div class="container p-md-5">

    <div class="float-right m-2 text-right">
        <button type="button" class="btn btn-info">Deliver this journal to Bobbert<i class="fas fa-arrow-alt-circle-right ml-2"></i></button>
    </div>

    <h1>{{ $journal['title'] }}</h1>
    <p class="font-italic">{{ $journal['description'] }}</p>

    <div class="alert alert-warning alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>Time is almost out!</strong> Your time with this journal will end in 23 hours.
    </div>

    <table class="mb-3"><tr><th>Countdown:</th><td>23 hours, 23 minutes</td></tr></table>

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
