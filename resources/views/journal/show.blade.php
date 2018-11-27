@extends('layout.journal')

@section('additional_link_tags')
{{-- CSS NEEDED FOR TO DISPLAY QUILL-EDITED TEXT --}}
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection

@section('page-title', $journal->title)

@section('journal-content')
<div class="container">

    <journal-card
        class="d-md-none mt-3"
        auth-user-json="{{ Auth::user() }}"
        read-url="{{ Auth::user()->can('view', $journal) ? route('journal.contents', $journal) : '' }}"
        image-url="{{ Storage::url('img/cover1.jpg') }}"
        settings-url="{{ Auth::user()->can('viewSettings', $journal) ? route('journal.settings', $journal) : '' }}"
        queue-json="{{ $journal->queue }}"
        journal-json="{{ $journal }}"
    ></journal-card>

    @if ($journal->queue->count())
        <journal-countdown
            target-date-string="{{ $journal->next_change }}"
            rotate-url="{{ route('api.journal.rotate', $journal) }}"
        ></journal-countdown>
    @endif

    <h2>Your entries</h2>
    <p>While you have this journal, you can read previous entries as well as add new ones. The entries you add now can be edited later as long as you have this journal, but once your turn is over, they will be published to the journal permanently. <strong>So make sure your entries are finished before the timer runs out!</strong></p>

    @component('component.addButton')
        @slot('url', route('journal.add', $journal))
        Add a new entry
    @endcomponent

    @if(count($drafts))
        {{ $drafts->links() }}
    @else
        <alert level="secondary" :dismissible="false">You haven't added any entries yet. Time to get writing!</alert>
    @endif

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

</div>
@endsection
