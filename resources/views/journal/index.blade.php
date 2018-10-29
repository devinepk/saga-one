@extends('layout.page')

@section('page-title', 'My Journals')

@section('page-content')
<main class="container">
    <h1 class="my-5">My Journals</h1>
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
                            <h2 class="card-title"><a href="/journal/read">{{ $journal['title'] }}</a></h2>
                            <nav class="nav flex-column">
                                <a class="nav-link py-1" href="/journal/write"><i class="fas fa-fw fa-plus mr-2"></i>New post</a>
                                <a class="nav-link py-1" href="/journal/read"><i class="fas fa-fw fa-book-reader mr-2"></i>Read latest</a>
                                <a class="nav-link py-1" href="/journal/contents"><i class="fab fa-fw fa-readme mr-2"></i>All entries</a>
                            </nav>
                        </div>
                    </div>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><h5 class="m-0">People in this journal:</h5></li>
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
    <a class="btn btn-block py-3 my-5" style="border: 3px dashed #ccc;" href="/journal/create"><i class="fas fa-plus"></i></a>
</main>
@endsection
