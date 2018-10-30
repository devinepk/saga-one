@extends('layout.journal')

@section('additional_link_tags')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection

@section('page-title', 'Edit Entry')

@section('journal-content')
<div class="sticky-top pt-5 bg-white border-bottom">
    <div class="ml-2 mr-2">
        <h1 class="entry-title">{{ $entry['title'] }}</h1>
        {{-- <small class="entry-meta text-muted">Posted on Friday, October 26 at 3:59 PM by <a href="#">Bobby Bob</a></small> --}}
    </div>
</div>

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
