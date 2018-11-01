@extends('layout.page')

@section('page-title', 'Create a new journal')

@section('page-content')
<main class="container p-md-5">
    <h1>Create a new journal</h1>
    <form method="post" action="">
        @csrf
        <div class="form-group my-5">
            <label for="title">Give this journal a title:</label>
            <input class="form-control" id="title" name="title">
        </div>
        <div class="form-group my-5">
            <label for="description">Give this journal a short description:</label>
            <input type="text" class="form-control" id="description" name="description">
        </div>
        <div class="form-group my-5">
            <div class="custom-file">
                <label class="custom-file-label" for="cover_img">Upload a cover image for this journal</label>
                <input type="file" class="custom-file-input" id="cover_img" name="cover_img">
            </div>
        </div>
        {{--
        <div class="form-group my-5">
            <label for="participants">Add some friends to this journal:</label>
            <input type="text" id="participants" class="form-control" placeholder="Search friends">
        </div>
        <div class="form-group my-5">
            <label>Set rotation order:</label>
            <ul class="list-group">
                <li class="list-group-item list-group-item-action active">Bobby Bob (You)</li>
                @foreach ($friends as $friend)
                    <li class="list-group-item list-group-item-action">{{ $friend }}</li>
                @endforeach
            </ul>
        </div>
        --}}
        <div class="form-group my-5">
            <button type="submit" class="btn btn-block btn-primary">Create</button>
        </div>
    </form>
</main>
@endsection
