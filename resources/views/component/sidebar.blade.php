<nav class="col-md-3 d-none d-md-block bg-light sidebar">

    <journal-card
        write-url="{{ Auth::user()->can('addEntry', $journal) ? route('journal.show', $journal) : '' }}"
        read-url="{{ Auth::user()->can('view', $journal) ? route('journal.contents', $journal) : '' }}"
        image-url="{{ Storage::url($journal->image_path) }}"
        settings-url="{{ Auth::user()->can('viewSettings', $journal) ? route('journal.settings', $journal) : '' }}"
        queue-json="{{ $journal->queue }}"
        class="border-top-0 border-left-0"
    ></journal-card>

</nav>
