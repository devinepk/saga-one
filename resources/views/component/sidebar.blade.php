<nav class="col-md-3 d-none d-md-block bg-light sidebar">

        <a href="{{ route('journal.show', $journal) }}">
            <img src="{{ asset('/img/cover1.jpg') }}" width="150" height="217" class="mx-auto d-block">
        </a>

        <h5 class="text-center mt-1">
            <a href="{{ route('journal.show', $journal) }}">{{ $journal['title'] }}</a>
        </h5>

        <div>
            <h6 class="mx-3 mt-5">In this journal:</h6>

            <ul class="list-group list-group-flush border-right border-bottom">

                @foreach ($journal->queue as $user)

                    <li class="list-group-item list-group-item-action">

                        <font-awesome-icon icon="user"></font-awesome-icon>
                        <span class="ml-2">{{ $user->name }}</span>

                    </li>

                @endforeach

            </ul>
        </div>
</nav>
