@extends('layout.page')

@section('page-title', 'Create a new journal')

@section('page-content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><h1 class="mb-0">Create a new journal</h1></div>
            <div class="card-body">
                <form method="post" action="{{ route('journal.store') }}" id="create-form">
                    @csrf
                    <div class="form-group">
                        <label for="title">Give this journal a title:</label>
                        <input class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" id="title" name="title" value="{{ old('title') }}"required autofocus>
                        @if ($errors->has('title'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="description">Give this journal a short description:</label>
                        <input type="text" class="form-control" id="description" name="description">
                    </div>
                </form>
            </div>
            <div class="card-footer p-0">
                <div class="row no-gutters">
                    <div class="col-4">
                        <a class="btn btn-block" href="{{ route('journal.index') }}">Cancel</a>
                    </div>
                    <div class="col">
                        <button type="submit" form="create-form" class="btn btn-block btn-primary">Create</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
