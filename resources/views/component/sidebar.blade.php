<nav class="col-md-3 d-none d-md-block bg-light sidebar">

        <a href="{{ route('journal.show', $journal) }}">
            <img src="{{ asset('/img/cover1.jpg') }}" width="150" height="217" class="mx-auto d-block">
        </a>

        <h5 class="text-center mt-1">
            <a href="{{ route('journal.show', $journal) }}">{{ $journal->title }}</a>
        </h5>

        <nav class="nav justify-content-around">
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

            <a class="nav-link py-1" href="{{ route('journal.contents', $journal) }}">
                <font-awesome-icon :icon="['fab', 'readme']"></font-awesome-icon>
                <span class="ml-2">Contents</span>
            </a>
        </nav>

        @if ($journal->queue->count())
        <div>
            <h6 class="mx-3 mt-5">Journal queue:</h6>
            <ul class="list-group list-group-flush border-right border-bottom">
                @include('component.queue')
            </ul>
        </div>
        @endif
</nav>
