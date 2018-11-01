@extends('layout.journal')

@section('page-title', $journal->title)

@section('journal-content')
<div class="container pb-5 p-md-5">

    <button type="button" class="d-md-none btn btn-block btn-info mb-4"><span class="mr-2">Deliver this journal to Bobbert</span><font-awesome-icon icon="arrow-alt-circle-right"></font-awesome-icon></button>
    <div class="d-none d-md-block float-right">
        <button type="button" class="btn btn-info">Deliver this journal to Bobbert<i class="fas fa-arrow-alt-circle-right ml-2"></i></button>
    </div>

    <h1>{{ $journal->title }}</h1>
    <p class="font-italic">{{ $journal->description }}</p>
    <table class="mb-3"><tr><th>Countdown:</th><td>23 hours, 23 minutes</td></tr></table>

    <div class="my-4 alert alert-warning alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>Time is almost out!</strong> Your time with this journal will end in 23 hours.
    </div>


    @if ($journal['participants'])
    <div class="d-md-none mb-4">
        <h6 class="mx-3">In this journal:</h6>
        <div class="list-group">
            @foreach ($journal['participants'] as $participant)
                <a class="list-group-item list-group-item-action" href="#"><font-awesome-icon icon="user"></font-awesome-icon><span class="ml-2">{{ $participant['name'] }}</span></a>
            @endforeach
        </div>
    </div>
    @endif

    <a class="my-4 btn btn-block btn-primary" href="/journal/write"><font-awesome-icon icon="plus"></font-awesome-icon><span class="ml-2">Add a new entry</span></a>

    <h2>Your entries</h2>
    @if (isset($entries))
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
    @endif

</div>
@endsection
