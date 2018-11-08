@extends('layout.journal')

@section('page-title', 'New Entry')

@section('additional_link_tags')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection

@section('journal-content')
<entry-header>
    <input type="text" form="entry-save-form" id="title" name="title" class="border-0 w-100 {{ $errors->has('title') ? ' is-invalid' : '' }}" style="outline:none;" value="{{ old('title') }}" placeholder="Title" autofocus>
    @if ($errors->has('title'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('title') }}</strong>
        </span>
    @endif
</entry-header>

<quill-editor></quill-editor>

<entry-save-form form-id="entry-save-form" store-url="{{ route('entry.store') }}" :journal-id="{{ $journal->id }}">
    @csrf
</entry-save-form>
@endsection

@section('bottom_of_body')
<!-- Initialize Quill editor -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
@endsection
