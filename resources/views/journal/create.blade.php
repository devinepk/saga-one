@extends('layout.page')

@section('page-title', 'Create a new journal')

@section('page-content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><h1 class="mb-0">Create a new journal</h1></div>
            <div class="card-body">
                <form method="post" action="{{ route('journal.store') }}" id="create-form" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="title">Give this journal a title:</label>
                        <input class="journal-title form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" id="title" name="title" value="{{ old('title') }}"required autofocus>
                        @if ($errors->has('title'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="description">Give this journal a short description (optional):</label>
                        <input type="text" class="font-italic form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" id="description" value="{{ old('description') }}" name="description">
                        @if ($errors->has('description'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="cover_image">Cover image (optional):
                            <help-icon
                                text="Images should be under 2MB"
                                class="ml-1"
                            ></help-icon>
                        </label>
                        <file-input
                            errors-json="{{ $errors }}"
                            name="cover_image"
                            id="cover_image"
                            initial-placeholder="Choose a file"
                        ></file-input>
                    </div>

                    <div class="form-group">
                        <label for="period">How often should this journal rotate?</label>
                        <select id="period" name="period" class="custom-select" required>
                            <option value="86400">Every day</option>
                            <option value="604800" selected>Every week</option>
                            <option value="{{ 604800 * 2 }}">Every two weeks</option>
                            <option value="{{ 604800 * 3 }}">Every three weeks</option>
                            <option value="{{ 604800 * 4 }}">Every four weeks</option>
                        </select>
                        @if ($errors->has('period'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('period') }}</strong>
                            </span>
                        @endif
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
