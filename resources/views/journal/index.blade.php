@extends('layout.journal')

@section('page-title', $journal['title'])

@section('journal-content')
<div class="container p-md-5">
    <h1>{{ $journal['title'] }}</h1>
    <p class="font-italic">{{ $journal['description'] }}</p>

    <h2>Details</h2>

    <h2>Latest entries</h2>

    <a href="/journal/contents">View all entries</a>
</div>
@endsection
