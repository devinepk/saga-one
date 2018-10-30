@extends('layout.journal')

@section('page-title', $journal['title'])

@section('journal-content')
<div class="container p-md-5">
    <h1>Entries in {{ $journal['title'] }}</h1>
    @foreach ($entries as $entry)
        <div class="card mb-5">
            <div class="card-header">
                <a class="float-right m-2 text-muted" href="/journal/write"><i class="fas fa-edit"></i></a>
                <h2 class="m-0"><a href="/journal/read">{{ $entry['title'] }}</a></h2>
            </div>
            <div class="card-body">
                <p class="m-0 excerpt">{{ $entry['excerpt'] }}</p>
            </div>
            <div class="card-footer text-muted">
                <span>Written by <a href="#">{{ $entry['author']}}</a> on {{ $entry['created'] }}</span>
            </div>
        </div>
    @endforeach
</div>
@endsection
