@extends('layout.page')

@section('page-title', 'Create a new journal')

@section('page-content')
<main class="container">
    <h1 class="mb-4">Create a new journal</h1>
    <form method="post" action="" class="m-5">
        <div class="form-group">
            <label for="title">Journal title:</label>
            <input class="form-control" id="title" name="title">
        </div>
        <div class="form-group">
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="cover_img" name="cover_img">
                <label class="custom-file-label" for="cover_img">Upload a journal cover</label>
            </div>
        </div>
        <div class="form-group">
            <label for="participants">Select participants:</label>
            <select id="participants" name="participants" class="form-control" size="10" multiple>
                @foreach ($friends as $friend)
                    <option selected>{{ $friend }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Set rotation order:</label>
            <ul class="list-group">
                @foreach ($friends as $friend)
                    <li class="list-group-item">{{ $friend }}</li>
                @endforeach
            </ul>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-block btn-primary">Create</button>
        </div>
    </form>
</main>
@endsection
