@extends('layout.journal')

@section('additional_link_tags')
{{-- CSS NEEDED FOR TO DISPLAY QUILL-EDITED TEXT --}}
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection

@section('page-title', $journal->title)

@section('journal-content')
<div class="container">

    <h1>Write in {{ $journal->title }}</h1>

    <journal-card class="d-md-none mt-3"></journal-card>

    @if ($journal->queue->count() > 1)
        <journal-countdown
            target-date-string="{{ $journal->next_change }}"
            rotate-url="{{ route('api.journal.rotate', $journal) }}"
            add-entry-url="{{ route('journal.add', $journal) }}"
            :entry-count="{{ $drafts->count() }}"
        ></journal-countdown>
    @endif

    @if ($drafts->count())
        {{ $drafts->links() }}

        @foreach ($drafts as $draft)
            <entry-card
                entry-json="{{ $draft }}"
                edit-url="{{ route('entry.edit', $draft) }}"
                title-url="{{ route('entry.edit', $draft) }}"
                delete-url="{{ route('entry.destroy', $draft) }}"
            >
                <template slot="deleteformfields">@csrf @method('DELETE')</template>
            </entry-card>
        @endforeach

        {{ $drafts->links() }}
    @endif

</div>
@endsection
