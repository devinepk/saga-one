@extends('layout.journal')

@section('page-title', $journal->title)

@section('journal-content')
<div class="container">

    <journal-card
        class="d-md-none mt-3"
        auth-user-json="{{ Auth::user() }}"
        read-url="{{ Auth::user()->can('view', $journal) ? route('journal.contents', $journal) : '' }}"
        image-url="{{ asset('/img/cover1.jpg') }}"
        settings-url="{{ Auth::user()->can('viewSettings', $journal) ? route('journal.settings', $journal) : '' }}"
        queue-json="{{ $journal->queue }}"
        journal-json="{{ $journal }}"
    ></journal-card>

    @if ($journal->queue->count())
        <journal-countdown target-date-string="{{ $journal->next_change }}"></journal-countdown>
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
        <div class="alert alert-secondary">You haven't started any new entries. Time to get writing!</div>
    @endif

    @foreach ($drafts as $draft)
        <entry-card
            entry-json="{{ $draft }}"
            edit-url="{{ route('entry.edit', $draft) }}"
            title-url="{{ route('entry.edit', $draft) }}"
            delete-url="{{ route('entry.destroy', $draft) }}"
            created-at-string="{{ $draft->created_at }}"
            updated-at-string="{{ $draft->updated_at }}"
        >
            {!! $draft->excerpt !!}
            <template slot="deleteformfields">@csrf @method('DELETE')</template>
        </entry-card>
    @endforeach

</div>
@endsection
