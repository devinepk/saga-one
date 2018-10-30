@extends('layout.journal')

@section('page-title', 'Read')

@section('journal-content')
<div class="sticky-top pt-5 bg-white border-bottom">

    <nav class="nav justify-content-between mb-4">
        <a class="nav-item nav-link" href="#"><i class="fas fa-backward mr-2"></i><span class="d-none d-md-inline">Previous Entry</span></a>
        <a class="nav-item nav-link" href="#">Table of Contents</a>
        <a class="nav-item nav-link" href="#"><span class="d-none d-md-inline">Next Entry</span><i class="fas fa-forward ml-2"></i></a>
    </nav>

    <div class="float-right m-2">
        <a class="text-muted" href="#"><i class="fas fa-edit"></i></a>
    </div>

    <div class="m-2">
        <h1 class="entry-title mb-0">{{ $entry['title'] }}</h1>
        <small class="entry-meta text-muted">Written on Friday, October 26 at 3:59 PM by <a href="#">Bobby Bob</a></small>
    </div>

</div>

<div class="row no-gutters">
    <div class="col-lg-8">

        <entry-body body="{!! $entry['body'] !!}"></entry-body>

    </div>

    <div class="d-none d-lg-block col-lg-4 p-2">
        <div class="card">
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
