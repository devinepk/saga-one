@extends('layout.journal')

@section('additional_link_tags')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection

@section('page-title', 'Edit Entry')

@section('journal-content')
<entry-header>
    {{ $entry['title'] }}
</entry-header>

<div id="edit-content" class="">
    <div id="editor" class="p-2">
        {!! $entry['body'] !!}
    </div>
</div>
@endsection

@section('bottom_of_body')
<!-- Include the Quill library -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<!-- Initialize Quill editor -->
<script>
var quill = new Quill('#editor', {
    theme: 'snow'
});
</script>
@endsection
