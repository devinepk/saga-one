@extends('layout.journal')

@section('page-title', $entry->title)

@section('journal-content')
<entry-header
    :display-entry-nav="true"
    entry-date="{{ $entry->formatted_updated_at }}"
    author="{{ $entry->author->name }}"
    edit-url="{{ route('entry.edit', $entry) }}"
    @if($journal->getEntryBefore($entry))
        previous-url="{{ route('entry.show', $journal->getEntryBefore($entry)) }}"
    @endif
    @if ($journal->getEntryAfter($entry))
        next-url="{{ route('entry.show', $journal->getEntryAfter($entry)) }}"
    @endif
    contents-url="{{ route('journal.contents', $journal) }}"
>
    {{ $entry->title }}
</entry-header>

<div class="row no-gutters">
    <div class="col-lg-8">

        <entry-body body="{!! $entry->body !!}"></entry-body>

    </div>

    <div class="col-lg-4 p-2">
        <div class="card mb-3">
            @if (isset($entry->comments))
            <div class="card-body border-0">
                @foreach ($entry->comments as $comment)
                <entry-comment author="{{ $comment->author }}">
                    {{ $comment->message }}
                </entry-comment>
                @endforeach
            </div>
            @endif
            <form class="card-footer p-0" id="add-comment-form" method="post" action="">
                <input type="text" onclick="document.getElementByEd('add-comment-form').submit();" id="new_comment" name="new_comment" class="form-control border-0" placeholder="Write a comment...">
            </form>
        </div>
    </div>
</div>
@endsection
