@extends('layout.journal')

@section('additional_link_tags')
{{-- CSS NEEDED FOR TO DISPLAY QUILL-EDITED TEXT --}}
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection

@section('page-title', "Entries in {$journal->title}")

@section('journal-content')
<div class="container">

    @if (!$journal->active)

        <alert level="primary" :dismissible="false">
            <h4>This journal has been archived.</h4>
            <p>Archived journals are "sealed" and can no longer be written in. They are also removed from rotation, which means everyone in the journal can read them anytime.</p>
            @if (Auth::user()->can('archive', $journal))
                <p>You may reopen this journal from the <a href="{{ route('journal.settings', $journal) }}">journal settings page</a>.</p>
            @else
                <p>Talk to {{ $journal->creator->name }}, the creator of this journal, if you wish to reopen this journal again.</p>
            @endif
        </alert>

    @endif

    <journal-card
        class="d-md-none mt-3"
        auth-user-json="{{ Auth::user() }}"
        read-url="{{ Auth::user()->can('view', $journal) ? route('journal.contents', $journal) : '' }}"
        write-url="{{ Auth::user()->can('addEntry', $journal) ? route('journal.show', $journal) : '' }}"
        image-url="{{ asset('/img/cover1.jpg') }}"
        settings-url="{{ Auth::user()->can('viewSettings', $journal) ? route('journal.settings', $journal) : '' }}"
        queue-json="{{ $journal->queue }}"
        journal-json="{{ $journal }}"
    ></journal-card>


    @if (count($entries))

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

        {{ $entries->links() }}

    @else

        <alert level="secondary" :dismissible="false">
            This journal is empty. Time to get writing!
        </alert>

    @endif

</div>
@endsection
