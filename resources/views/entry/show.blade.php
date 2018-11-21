@extends('layout.journal')

@section('additional_link_tags')
{{-- CSS NEEDED FOR TO DISPLAY QUILL-EDITED TEXT --}}
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection

@section('page-title', $entry->title)

@section('journal-content')
<entry-header
    :display-entry-nav="true"
    entry-json="{{ $entry }}"
    author-json="{{ $entry->author }}"
    edit-url="{{ Auth::user()->can('update', $entry) ? route('entry.edit', $entry) : '' }}"
    @if($journal->getEntryBefore($entry))
        previous-url="{{ route('entry.show', $journal->getEntryBefore($entry)) }}"
    @endif
    @if ($journal->getEntryAfter($entry))
        next-url="{{ route('entry.show', $journal->getEntryAfter($entry)) }}"
    @endif
    contents-url="{{ route('journal.contents', $journal) }}"
>{{ $entry->title }}</entry-header>

<div class="row no-gutters entry-container">

    <div class="col-lg-8">

        <entry-body body="{{ $entry->body }}"></entry-body>

    </div>

    <div class="col-lg-4 p-2">

        <comments-card
            comments-json="{{ $entry->comments()->with('user')->get()->toJson() }}"
            post-url="{{ route('api.comment.add', $entry, false) }}"
            auth-user-json="{{ Auth::user() }}"
        ></comments-card>

    </div>
</div>
@endsection
