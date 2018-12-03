@extends('layout.page')

@section('page-title', 'My Journals')

@section('page-content')
<h1 class="mb-4">Your journals</h1>

@if (count($journals))

    <div class="row">

        @foreach($journals as $journal)
            <div class="col-md-6 col-lg-4">
                <journal-card journal-json="{{ $journal }}"></journal-card>
            </div>
        @endforeach
    </div>

@else

    <alert level="primary">
        You don't have any journals. <a class="alert-link" href="{{ route('journal.create') }}">Create one</a> and invite your friends!
    </alert>

@endif
@endsection

@section('page-footer')
    @component('component.addButton')
        @slot('url', route('journal.create'))
        Create a new journal
    @endcomponent
@endsection
