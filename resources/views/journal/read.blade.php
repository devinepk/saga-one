@extends('layout.journal')

@section('page-title', 'Read')

@section('journal-content')
<div class="sticky-top pt-5 bg-white border-bottom">
    <div class="float-right">
        <a class="text-muted" href="#"><i class="fas fa-edit ml-3"></i></a>
    </div>
    <h1 class="entry-title">{{ $journal['title'] }}</h1>

</div>
<div class="row no-gutters">
    <div class="col-lg-8">
        <div class="entry-body">{!! $journal['body'] !!}</div>
    </div>

    <div class="d-none d-lg-block col-lg-4">
        (Comment area)
    </div>
</div>
@endsection
