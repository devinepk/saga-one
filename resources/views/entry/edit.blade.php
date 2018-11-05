@extends('layout.journal')

@section('page-title', 'Edit Entry')

@section('journal-content')
<entry-header>
    {{ $entry->title }}
</entry-header>

<form method="post" action="{{ route('entry.update', $entry) }}">
    @csrf
    @method('PUT')
    <input type="hidden" name="journal_id" value="{{ $journal->id }}">
    <input type="text" id="title" name="title" class="form-control" value="{{ $entry->title }}">
    <textarea id="body" name="body" class="form-control">{{ $entry->body }}</textarea>
    <button type="submit" class="btn btn-primary">Save</button>
</form>
@endsection
