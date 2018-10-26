@extends('layout.journal')

@section('page-title', 'Read')

@section('journal-content')
<div class="sticky-top pt-5 bg-white border-bottom">

    <nav class="nav justify-content-between">
        <a class="nav-item nav-link" href="#"><i class="fas fa-backward mr-2"></i>Previous Entry</a>
        <a class="nav-item nav-link" href="#">Table of Contents</a>
        <a class="nav-item nav-link" href="#">Next Entry<i class="fas fa-forward ml-2"></i></a>
    </nav>

    <div class="float-right m-2">
        <a class="text-muted" href="#"><i class="fas fa-edit"></i></a>
    </div>

    <div class="m-2">
        <h1 class="entry-title mb-0">{{ $journal['title'] }}</h1>
        <small class="entry-meta text-muted">Posted on Friday, October 26 at 3:59 PM by <a href="#">Bobby Bob</a></small>
    </div>

</div>

<div class="row no-gutters">
    <div class="col-lg-8">
        <div class="entry-body pl-2">{!! $journal['body'] !!}</div>
    </div>

    <div class="d-none d-lg-block col-lg-4">
        (Comment area)
    </div>
</div>
@endsection
