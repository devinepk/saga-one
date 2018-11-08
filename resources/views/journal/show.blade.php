@extends('layout.journal')

@section('page-title', $journal->title)

@section('journal-content')
<div class="container pb-5 p-md-5">

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

    <p>You have this journal until <strong>{{ $journal->formatted_next_change }}</strong>.</p>
    <journal-countdown target-date-string="{{ $journal->next_change }}"></journal-countdown>

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
        @slot('url', route('journal.add', $journal))
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
            edit-url="{{ route('entry.edit', $draft) }}"
            title-url="{{ route('entry.edit', $draft) }}"
            delete-url="{{ route('entry.destroy', $draft) }}"
            created-at="{{ $draft->formatted_created_at }}"
            updated-at="{{ $draft->formatted_updated_at }}"
        >
            {!! $draft->excerpt !!}
            <template slot="deleteformfields">@csrf @method('DELETE')</template>
        </entry-card>
    @endforeach

</div>
@endsection
