@extends('layout.page')

@section('page-title', 'My Journals')

@section('page-content')
<main class="container">
    <h1 class="mb-4">My Journals</h1>
    <div class="row">
    @foreach ($journals as $journal)
        <div class="col-md">
            <div class="card mb-5">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md mb-3 mb-md-0 journal-card-cover" style="background-image:url('{{ $journal['cover_url'] }}')">
                            <a href="#"></a>
                        </div>
                        <div class="col-md">
                            <h2 class="card-title"><a href="#">{{ $journal['title'] }}</a></h2>
                        </div>
                    </div>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><h5 class="m-0">Participants</h5></li>
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
