@extends('layout.journal')

@section('page-title', $journal->title)

@section('journal-content')
<div class="container pb-5 p-md-5">

    {{--
    <button type="button" class="d-md-none btn btn-block btn-info mb-4"><span class="mr-2">Deliver this journal to Bobbert</span><font-awesome-icon icon="arrow-alt-circle-right"></font-awesome-icon></button>
    <div class="d-none d-md-block float-right">
        <button type="button" class="btn btn-info">Deliver this journal to Bobbert<i class="fas fa-arrow-alt-circle-right ml-2"></i></button>
    </div>
    --}}

    <h1>{{ $journal->title }}</h1>
    @if ($journal->description)
    <p class="font-italic">{{ $journal->description }}</p>
    @endif

    @if (Auth::id() == $journal->creator->id)
    <nav class="nav d-md-none">
        <a class="nav-link py-1" href="{{ route('journal.invite', $journal) }}">
            <font-awesome-icon icon="user-plus"></font-awesome-icon>
            <span class="ml-2">Invite</span>
        </a>

        <a class="nav-link py-1" href="{{ route('journal.edit', $journal) }}">
            <font-awesome-icon icon="edit"></font-awesome-icon>
            <span class="ml-2">Edit</span>
        </a>

        <a class="nav-link py-1" href="{{ route('journal.confirmDelete', $journal) }}">
            <font-awesome-icon icon="trash-alt"></font-awesome-icon>
            <span class="ml-2">Delete</span>
        </a>
    </nav>
    @endif

    <table class="my-3"><tr><th>Countdown:</th><td>23 hours, 23 minutes</td></tr></table>

    <div class="my-4 alert alert-warning alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>Time is almost out!</strong> Your time with <strong>{{ $journal->title }}</strong> will end in 23 hours.
    </div>


    @if ($journal->queue->count())
    <div class="d-md-none mb-4">
        <h6 class="mx-3">Journal queue:</h6>
        <ul class="list-group list-group-flush border-right border-bottom">
            @include('component.queue')
        </ul>
    </div>
    @endif



    <h2>Your draft entries</h2>

    @if (count($drafts))
        <p>You can edit these entries now, but when the journal moves to the next person, they'll be posted to the journal permanently and no further edits will be possible.</p>
    @endif

    @component('component.addButton')
        @slot('url', route('journal.addEntry', $journal))
        Add a new entry
    @endcomponent

    @if(count($drafts))
        {{ $drafts->links() }}
    @else
        <div class="alert alert-info">You haven't started any new entries. Time to get writing!</div>
    @endif

    @foreach ($drafts as $draft)
        <entry-card
            title="{{ $draft->title }}"
            edit-url="{{ route('entry.edit', ['entry' => $draft, 'journal' => $journal]) }}"
            title-url="{{ route('entry.edit', ['entry' => $draft, 'journal' => $journal]) }}"
            delete-url="{{ route('entry.destroy', ['entry' => $draft, 'journal' => $journal]) }}"
            created-at="{{ $draft->formatted_created_at }}"
            updated-at="{{ $draft->formatted_updated_at }}"
        >
            {!! $draft->excerpt !!}
            <template slot="deleteformfields">@csrf @method('DELETE')</template>
        </entry-card>
    @endforeach

</div>
@endsection
