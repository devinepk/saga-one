@extends('layout.journal')

@section('page-title', 'Read')

@section('journal-content')
<entry-header
    :display-entry-nav="true"
    edit-url="#"
    created-on="Friday, October 26 at 3:59 PM"
    author="Bobby Bob"
    author-url="#"
>
    {{ $entry->title }}
</entry-header>

<div class="row no-gutters">
    <div class="col-lg-8">

        <entry-body body="{!! $entry->body !!}"></entry-body>

    </div>

    <div class="col-lg-4 p-2">
        <div class="card mb-3">
            <div class="card-body border-0">
                @foreach ($comments as $comment)
                <entry-comment author="{{ $comment['author'] }}">
                    {{ $comment['message'] }}
                </entry-comment>
                @endforeach
            </div>
            <form class="card-footer p-0">
                <input type="text" id="new_comment" name="new_comment" class="form-control border-0" placeholder="Write a comment...">
            </form>
        </div>
    </div>
</div>
@endsection
