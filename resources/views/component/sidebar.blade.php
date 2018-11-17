<nav class="col-md-3 d-none d-md-block bg-light sidebar">

    <journal-card
        auth-user-json="{{ Auth::user() }}"
        write-url="{{ Auth::user()->can('addEntry', $journal) ? route('journal.show', $journal) : '' }}"
        read-url="{{ Auth::user()->can('view', $journal) ? route('journal.contents', $journal) : '' }}"
        image-url="{{ asset('/img/cover1.jpg') }}"
        settings-url="{{ Auth::user()->can('viewSettings', $journal) ? route('journal.settings', $journal) : '' }}"
        queue-json="{{ $journal->queue }}"
        journal-json="{{ $journal }}"
        :bubble="true"
        class="border-top-0 border-left-0"
    >
    </journal-card>

</nav>
