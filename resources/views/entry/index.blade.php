@extends('layout.journal')

@section('page-title', "Entries in {$journal->title}")

@section('journal-content')
<div class="container">

    @if ($journal->active)

        @if (count($entries))
            <h1>{{ $journal->title }}</h1>

            @component('component.addButton')
                @slot('url', route('journal.add', $journal))
                Add a new entry
            @endcomponent

            {{ $entries->links() }}

            @foreach ($entries as $entry)
                <entry-card
                    entry-json="{{ $entry }}"
                    author-json="{{ $entry->author }}"
                    title-url="{{ route('entry.show', $entry) }}"
                    updated-at-string="{{ $entry->updated_at }}"
                >
                    {!! $entry->excerpt !!}
                </entry-card>
            @endforeach

        @else
            <alert level="secondary">
                This journal is empty. Time to get writing!
            </alert>

            @component('component.addButton')
                @slot('url', route('journal.add', $journal))
                Add a new entry
            @endcomponent

        @endif

    @else

        <alert level="primary" :dismissible="false">
            <h4>This journal has been archived.</h4>
            <p>Archived journals are "sealed" and can no longer be written in. They are also removed from rotation, which means everyone in the journal can read it anytime.</p>
            @if (Auth::user()->can('archive', $journal))
                <p>You may reopen this journal from the <a href="{{ route('journal.settings', $journal) }}">journal settings page</a>.</p>
            @else
                <p>Talk to {{ $journal->creator->name }}, the creator of this journal, if you wish to reopen this journal again.</p>
            @endif
        </alert>

    @endif
</div>
@endsection
