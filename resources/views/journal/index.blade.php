@extends('layout.page')

@section('page-title', 'My Journals')

@section('page-content')
<main class="container">
    <h1 class="mb-4">My Journals</h1>
    <div class="row">
    @foreach ($journals as $journal)
        <div class="col-md">
            <div class="card mb-5">
                <img class="card-img-top" src="{{ $journal['cover_url'] }}" width="150" height="217">
                <div class="card-body">
                    <h2 class="card-title">{{ $journal['title'] }}</h2>
                    <p class="card-text">You are writing this journal with:</p>
                </div>
                <ul class="list-group list-group-flush">
                    @foreach ($journal['participants'] as $participant)
                        <li class="list-group-item"><a href="#"><i class="fas fa-user user-pic"></i>{{ $participant }}</a></li>
                    @endforeach
                </ul>
                <div class="card-footer border-top-0">
                    <small class="text-muted">This journal is in your possession.</small>
                </div>
            </div>
        </div>
    @endforeach
    </div>
</main>
@endsection
