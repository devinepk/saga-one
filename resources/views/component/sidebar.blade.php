<nav class="col-md-3 d-none d-md-block bg-light sidebar">

        <a href="{{ route('journal.show', $journal) }}">
            <img src="{{ asset('/img/cover1.jpg') }}" width="150" height="217" class="mx-auto d-block">
        </a>

        <h5 class="text-center mt-1">
            <a href="{{ route('journal.show', $journal) }}">{{ $journal->title }}</a>
        </h5>

        <nav class="nav justify-content-around">
            @if (Auth::user()->can('invite', $journal))
                <a class="nav-link py-1" href="{{ route('journal.invite', $journal) }}">
                    <font-awesome-icon icon="user-plus"></font-awesome-icon>
                    <span class="ml-2">Invite</span>
                </a>
            @endif

            @if (Auth::user()->can('update', $journal))
                <a class="nav-link py-1" href="{{ route('journal.edit', $journal) }}">
                    <font-awesome-icon icon="edit"></font-awesome-icon>
                    <span class="ml-2">Edit</span>
                </a>
            @endif

            @if (Auth::user()->can('archive', $journal))
                <button type="button" class="btn btn-link nav-link border-0 text-left py-1" data-toggle="modal" data-target="#archive-confirm">
                    <font-awesome-icon icon="archive"></font-awesome-icon>
                    <span class="ml-2">Archive</span>
                </button>

                <modal modal-id="archive-confirm">
                    <template slot="title">Archive this journal?</template>
                    <p>Archived journals are "sealed" and can no longer be written in or edited in any way.</p>
                    <p>They are also removed from rotation, which means everyone in the journal will be able to read it anytime.</p>
                    <p>Are you sure you want to archive this journal?</p>
                    <template slot="footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                        <form class="d-inline" method="post" action="{{ route('journal.archive', $journal) }}">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-danger">Yes, archive</button>
                        </form>
                    </template>
                </modal>
            @endif

            @if (Auth::user()->can('view', $journal))
                <a class="nav-link py-1" href="{{ route('journal.contents', $journal) }}">
                    <font-awesome-icon :icon="['fab', 'readme']"></font-awesome-icon>
                    <span class="ml-2">Read</span>
                </a>
            @endif

            @if (Auth::user()->can('addEntry', $journal))
                <a class="nav-link py-1" href="{{ route('journal.show', $journal) }}">
                    <font-awesome-icon icon="edit"></font-awesome-icon>
                    <span class="ml-2">Your drafts</span>
                </a>
            @endif
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
