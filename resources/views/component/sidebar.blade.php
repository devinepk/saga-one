<nav class="col-md-3 d-none d-md-block bg-light sidebar">
        <a href="{{ route('journal.show', $journal) }}"><img src="{{ asset('/img/cover1.jpg') }}" width="150" height="217" class="mx-auto d-block"></a>
        <h5 class="text-center mt-1"><a href="{{ route('journal.show', $journal) }}">{{ $journal['title'] }}</a></h5>

        @if ($journal['participants'])
        <div>
            <h6 class="mx-3 mt-5">In this journal:</h6>
            <div class="list-group list-group-flush border-right border-bottom">
                @foreach ($journal['participants'] as $participant)
                    <a class="list-group-item list-group-item-action" href="#"><font-awesome-icon icon="user"></font-awesome-icon><span class="ml-2">{{ $participant['name'] }}</span></a>
                @endforeach
            </div>
        </div>
        @endif
</nav>
