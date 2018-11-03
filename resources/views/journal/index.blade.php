@extends('layout.page')

@section('page-title', 'My Journals')

@section('page-content')
@if (Auth::user()->current_journals->count())
    <h2 class="mt-5">Write in a journal</h2>
    <div class="row">
        @foreach(Auth::user()->current_journals as $journal)
        <div class="col-sm col-lg-4">
            <div class="card journal-card border-0 mb-5">
                <div class="card-body">

                    <h3 class="card-title"><a href="{{ route('journal.show', $journal) }}">{{ $journal->title }}</a></h3>

                    @if ($journal->description)
                        <p class="font-italic">{{ $journal->description }}</p>
                    @endif

                    <div class="row">

                        <div class="col-lg mb-3 text-center">

                            <a href="{{ route('journal.show', $journal) }}">
                                <img src="{{ asset('/img/cover1.jpg') }}" width="150" height="217">
                            </a>

                        </div>

                        <div class="col-lg">
                            <nav class="nav flex-column">

                                <a class="nav-link py-1" href="#">
                                    <font-awesome-icon icon="pencil-alt"></font-awesome-icon>
                                    <span class="ml-2">Write</span>
                                </a>

                                <a class="nav-link py-1" href="#">
                                    <font-awesome-icon icon="book-reader"></font-awesome-icon>
                                    <span class="ml-2">Read</span>
                                </a>

                                <a class="nav-link py-1" href="{{ route('journal.contents', $journal) }}">
                                    <font-awesome-icon :icon="['fab', 'readme']"></font-awesome-icon>
                                    <span class="ml-2">Contents</span>
                                </a>

                                @if (Auth::id() == $journal->creator->id)
                                <a class="nav-link py-1" href="{{ route('journal.invite', $journal) }}">
                                    <font-awesome-icon icon="user-plus"></font-awesome-icon>
                                    <span class="ml-2">Invite</span>
                                </a>

                                <a class="nav-link py-1" href="{{ route('journal.edit', $journal) }}">
                                    <font-awesome-icon icon="edit"></font-awesome-icon>
                                    <span class="ml-2">Edit</span>
                                </a>

                                <a class="nav-link py-1" href="{{ route('journal.confirmDelete', $journal) }}">
                                    <font-awesome-icon icon="trash-alt"></font-awesome-icon>
                                    <span class="ml-2">Delete</span>
                                </a>
                                @endif

                            </nav>
                        </div>
                    </div>
                </div>

                @if ($journal->users->count() > 1)

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><h5 class="m-0">Journal queue:</h5></li>
                        @foreach ($journal->queue as $user)
                            <li class="list-group-item"><font-awesome-icon icon="user"></font-awesome-icon><span class="ml-2">{{ $user->name }}</span></li>
                        @endforeach
                    </ul>

                    <div class="card-footer">
                    @if (Auth::id() == $journal->current_user->id)
                        <small>You've got this journal right now. What will you write?</small>
                    @else
                        <small class="text-muted">{{ $journal->current_user->name }} has this journal right now.</small>
                    @endif
                    </div>

                @elseif (Auth::id() == $journal->creator->id)

                    <div class="card-footer">
                        <small>The real magic begins when you share this journal with others. <a href="/journal/invite">Invite a friend</a> now!</small>
                    </div>

                @endif
            </div>
        </div>
        @endforeach
    </div>
@endif

@if (Auth::user()->other_journals->count())
    <h2 class="mt-5">Other Journals</h2>
    <div class="row">

    @foreach (Auth::user()->other_journals as $journal)
        <div class="col-sm col-lg-4">
            <div class="card journal-card border-0 mb-5">
                <div class="card-body">

                    <h3 class="card-title">{{ $journal->title }}</h3>

                    @if ($journal->description)
                        <p class="font-italic">{{ $journal->description }}</p>
                    @endif

                    <div class="row">

                        <div class="col-lg mb-3 text-center">
                            <img src="{{ asset('/img/cover1.jpg') }}" width="150" height="217">
                        </div>

                        @if (Auth::id() == $journal->creator->id)
                        <div class="col-lg">
                            <nav class="nav flex-column">
                                <a class="nav-link py-1" href="{{ route('journal.invite', $journal) }}">
                                    <font-awesome-icon icon="user-plus"></font-awesome-icon>
                                    <span class="ml-2">Invite</span>
                                </a>
                            </nav>
                        </div>
                        @endif

                    </div>
                </div>

                @if ($journal->users->count() > 1)

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><h5 class="m-0">Journal queue:</h5></li>
                        @foreach ($journal->queue as $user)
                            <li class="list-group-item"><font-awesome-icon icon="user"></font-awesome-icon><span class="ml-2">{{ $user->name }}</span></li>
                        @endforeach
                    </ul>

                    <div class="card-footer">
                        <small class="text-muted">{{ $journal->current_user->name }} has this journal right now.</small>
                    </div>

                @elseif (Auth::id() == $journal->creator->id)

                    <div class="card-footer">
                        <span>No one else is participating in this journal. The real magic begins when you share this journal with others. <a href="/journal/invite">Invite a friend</a> now!</span>
                    </div>

                @endif
            </div>
        </div>
    @endforeach
    </div>
@endif

@if (!Auth::user()->journals->count())
    <div class="alert alert-info">You don't have any journals. <a href="{{ route('journal.create') }}'">Create one</a> and invite your friends!</div>
@endif

<a class="btn btn-block btn-primary py-3 mb-5" href="/journal/create"><font-awesome-icon icon="plus"></font-awesome-icon></a>
@endsection
