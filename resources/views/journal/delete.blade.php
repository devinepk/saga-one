@extends('layout.page')

@section('page-title', 'Create a new journal')

@section('page-content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><p class="mb-0">Are you sure you want to delete {{ $journal->title }}?</p></div>
            <div class="card-body">
                <form method="post" action="{{ route('journal.destroy', $journal) }}">
                    @method('DELETE')
                    @csrf
                    <div class="row pt-3">
                        <div class="col-4">
                            <a class="btn btn-block" href="{{ route('journal.show', $journal) }}">Cancel</a>
                        </div>
                        <div class="col">
                            <button type="submit" class="btn btn-block btn-danger"><font-awesome-icon icon="trash-alt"></font-awesome-icon><span class="ml-2">Delete</span></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
