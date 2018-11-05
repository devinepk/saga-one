@extends('layout.journal')

@section('page-title', 'New Entry')

@section('journal-content')
<entry-header>
    [Untitled]
</entry-header>
<form method="post" action="{{ route('entry.store') }}">
    @csrf
    <input type="hidden" name="journal_id" value="{{ $journal->id }}">
    <input type="text" id="title" name="title" class="form-control" placeholder="Title">
    <textarea id="body" name="body" class="form-control"></textarea>
    <button type="submit" class="btn btn-primary">Save</button>
</form>
@endsection
