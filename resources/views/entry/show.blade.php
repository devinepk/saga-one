@extends('layout.journal')

@section('additional_link_tags')
{{-- CSS NEEDED FOR TO DISPLAY QUILL-EDITED TEXT --}}
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection

@section('page-title', $entry->title)

@section('journal-content')
<div class="entry-container d-flex h-100">
    <entry-header
        :display-entry-nav="true"
        entry-json="{{ $entry }}"
    >{{ $entry->title }}</entry-header>

    <div class="row no-gutters entry-body">

        <div class="col-lg-8">
            <div class="ql-editor ql-snow p-3">{!! $entry->body !!}</div>
        </div>

        <div class="col-lg-4 p-2">
            <comments-card
                comments-json="{{ $entry->comments()->with('user')->get()->toJson() }}"
                post-url="{{ route('api.comment.add', $entry) }}"
                auth-user-json="{{ Auth::user() }}"
            ></comments-card>
        </div>

    </div>
</div>
@endsection
