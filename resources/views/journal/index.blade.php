@extends('layout.page')

@section('page-title', 'My Journals')

@section('page-content')
<main class="container">
    <h1 class="my-5">Bob's Journals</h1>
    <div class="row">
    @foreach ($journals as $journal)
        <div class="col-sm col-xl-4">
            <div class="card journal-card border-0 mb-5">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg mb-3 text-center">
                            <a href="#"><img src="{{ $journal['cover_url'] }}" width="150" height="217"></a>
                        </div>
                        <div class="col-lg">
                            <h2 class="card-title text-center"><a href="/journal/read">{{ $journal['title'] }}</a></h2>
                            <nav class="nav flex-column">
                                <a class="nav-link py-1" href="/journal/write"><i class="fas fa-fw fa-plus mr-2"></i>Write</a>
                                <a class="nav-link py-1" href="/journal/read"><i class="fas fa-fw fa-book-reader mr-2"></i>Read</a>
                                <a class="nav-link py-1" href="/journal/contents"><i class="fab fa-fw fa-readme mr-2"></i>Contents</a>
                                <a class="nav-link py-1" href="/journal/invite"><i class="fas fa-fw fa-user-plus mr-2"></i>Invite</a>
                            </nav>
                        </div>
                    </div>
                </div>

                @if ($journal['participants'])
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><h5 class="m-0">Friends in this journal:</h5></li>
                    @foreach ($journal['participants'] as $participant)
                        <li class="list-group-item"><a href="#"><i class="fas fa-user list-user-pic"></i>{{ $participant['name'] }}</a></li>
                    @endforeach
                </ul>

                <div class="card-footer">
                    <small class="text-muted">You've got this journal right now.</small>
                </div>
                @else
                <div class="card-footer">
                    <span>No one else is participating in this journal. <a href="/journal/invite">Invite a friend!</a></span>
                </div>
                @endif
            </div>
        </div>
    @endforeach
    </div>
    <a class="btn btn-block btn-primary py-3 mb-5" href="/journal/create"><i class="fas fa-plus"></i></a>
</main>
@endsection
