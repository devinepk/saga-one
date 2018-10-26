@extends('layout.journal')

@section('page-title', 'Journal Contents')

@section('journal-content')
<h1>Journal Contents</h1>
    @foreach ($entries as $entry)
        <div class="card m-5">
            <a href="/journal/read"><h2 class="card-header">{{ $entry['title'] }}</h2></a>
            <div class="card-body">
                <p class="m-0 excerpt">{{ $entry['excerpt'] }}</p>
            </div>
            <div class="card-footer text-muted">
                <span>Written by <a href="#">{{ $entry['author']}}</a> on {{ $entry['created'] }}</span>
            </div>
        </div>
    @endforeach
@endsection
