@extends('layout.page')

@section('page-title', 'Create a new journal')

@section('page-content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><h1 class="mb-0">Create a new journal</h1></div>
            <div class="card-body">
                <form method="post" action="{{ route('journal.store') }}">
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
                    <div class="row pt-3">
                        <div class="col-4">
                            <button type="submit" class="btn btn-block btn-link" formaction="{{ route('journal.index') }}">Cancel</a>
                        </div>
                        <div class="col">
                            <button type="submit" class="btn btn-block btn-primary">Create</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
