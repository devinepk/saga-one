@extends('layout.page')

@section('page-title', "Edit {$journal->title}")

@section('page-content')
<main class="container p-md-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h1 class="mb-0">Update journal details</h1></div>
                <div class="card-body">
                    <form method="post" action="{{ route('journal.update', $journal) }}">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="title">Change this journal's title:</label>
                            <input class="form-control" id="title" name="title" value="{{ $journal->title }}">
                        </div>
                        <div class="form-group">
                            <label for="description">Change this journal's description:</label>
                            <input type="text" class="form-control" id="description" name="description" value="{{ $journal->description }}">
                        </div>
                        <div class="row pt-3">
                            <div class="col-4">
                                <button type="submit" class="btn btn-block btn-link" formaction="{{ route('journal.show', $journal) }}">Cancel</a>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-block btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection