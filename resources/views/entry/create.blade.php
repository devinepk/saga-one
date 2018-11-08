@extends('layout.journal')

@section('page-title', 'New Entry')

@section('additional_link_tags')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection

@section('journal-content')
<entry-header>
    <input type="text" form="entry-form" id="title" name="title" class="border-0 w-100 {{ $errors->has('title') ? ' is-invalid' : '' }}" style="outline:none;" value="{{ old('title') }}" placeholder="Title" autofocus>
    @if ($errors->has('title'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('title') }}</strong>
        </span>
    @endif
</entry-header>

<form method="post" id="entry-form" action="{{ route('entry.store') }}">
    @csrf
    <div id="editor-container"></div>
    <input type="hidden" name="journal_id" value="{{ $journal->id }}">
    <input type="hidden" id="entry-body" name="body">
</form>

<div class="row no-gutters fixed-bottom justify-content-end">
    <button type="button" onclick="submitEntryForm()" form="entry-form" class="col-md-9 btn btn-primary">Save</button>
</div>
@endsection

@section('bottom_of_body')


<!-- Initialize Quill editor -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    var toolbarOptions = [['bold', 'italic']];
    var quill = new Quill('#editor-container', {
        theme: 'snow',
        bounds: 'main',
        modules: {
            toolbar: toolbarOptions
        }
    });

    function submitEntryForm() {
        document.getElementById('entry-body').value = document.getElementsByClassName('ql-editor')[0].innerHTML;
        document.getElementById('entry-form').submit();
    }
</script>
@endsection
