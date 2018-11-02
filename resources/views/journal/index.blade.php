@extends('layout.page')

@section('page-title', 'My Journals')

@section('page-content')
<h1 class="my-5">My journals</h1>

<div class="row">

@foreach ($journals as $journal)
    <div class="col-sm col-lg-4">
        <div class="card journal-card border-0 mb-5">
            <div class="card-body">

                <h2 class="card-title"><a href="{{ route('journal.show', $journal) }}">{{ $journal->title }}</a></h2>

                @if ($journal->description)
                    <p class="font-italic">{{ $journal->description }}</p>
                @endif

                <div class="row">

                    <div class="col-lg mb-3 text-center">

                        <a href="{{ route('journal.show', $journal) }}">
                            <img src="{{ asset('/img/cover1.jpg') }}" width="150" height="217">
                        </a>

                    </div>

                    @if (Auth::user()->id == $journal->current_user->id || Auth::user()->id == $journal->creator->id)
                    <div class="col-lg">
                        <nav class="nav flex-column">

                            @if (Auth::user()->id == $journal->current_user->id)
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
                            @endif

                            @if (Auth::user()->id == $journal->creator->id)
                            <a class="nav-link py-1" href="{{ route('journal.invite', $journal) }}">
                                <font-awesome-icon icon="user-plus"></font-awesome-icon>
                                <span class="ml-2">Invite</span>
                            </a>
                            @endif
                        </nav>
                    </div>
                    @endif

                </div>
            </div>

            @if ($journal->users->count() > 1)

                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><h5 class="m-0">Journal queue:</h5></li>
                    @foreach ($journal->users as $user)
                        <li class="list-group-item"><font-awesome-icon icon="user"></font-awesome-icon><span class="ml-2">{{ $user->name }}</span></li>
                    @endforeach
                </ul>

                <div class="card-footer">
                @if (Auth::user()->id == $journal->current_user->id)
                    <small>You've got this journal right now. What will you write?</small>
                @else
                    <small class="text-muted">{{ $journal->current_user->name }} has this journal right now.</small>
                @endif
                </div>

            @else

                <div class="card-footer">
                    <span>No one else is participating in this journal. The real magic begins when you share this journal with others. <a href="/journal/invite">Invite a friend</a> now!</span>
                </div>

            @endif
        </div>
    </div>
@endforeach
</div>
<a class="btn btn-block btn-primary py-3 mb-5" href="/journal/create"><font-awesome-icon icon="plus"></font-awesome-icon></a>
@endsection
