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
                            <a href="/journal"><img src="{{ $journal['cover_url'] }}" width="150" height="217"></a>
                        </div>
                        <div class="col-lg">
                            <h2 class="card-title text-center"><a href="/journal">{{ $journal['title'] }}</a></h2>
                            <nav class="nav flex-column">
                                <a class="nav-link py-1" href="/journal/write"><font-awesome-icon icon="pencil-alt"></font-awesome-icon><span class="ml-2">Write</span></a>
                                <a class="nav-link py-1" href="/journal/read"><font-awesome-icon icon="book-reader"></font-awesome-icon><span class="ml-2">Read</span></a>
                                <a class="nav-link py-1" href="/journal/contents"><font-awesome-icon :icon="['fab', 'readme']"></font-awesome-icon><span class="ml-2">Contents</span></a>
                                <a class="nav-link py-1" href="/journal/invite"><font-awesome-icon icon="user-plus"></font-awesome-icon><span class="ml-2">Invite</span></a>
                            </nav>
                        </div>
                    </div>
                </div>

                @if ($journal['participants'])
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><h5 class="m-0">Next up for this journal:</h5></li>
                    @foreach ($journal['participants'] as $participant)
                        <li class="list-group-item"><a href="#"><font-awesome-icon icon="user"></font-awesome-icon><span class="ml-2">{{ $participant['name'] }}</span></a></li>
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
