@extends('layout.page')

@section('page-title', 'Invite a friend')

@section('page-content')
<main class="container p-md-5">
    <h1>Invite a friend to join {{ $journal['title'] }}</h1>
    <p class="font-italic">{{ $journal['description'] }}</p>
    <form method="post" action="">
        <div class="form-group my-5">
            <label for="email">Email address:</label>
            <input type="email" class="form-control" id="email" name="title">
        </div>
        <div class="form-group my-5">
            <button type="submit" class="btn btn-block btn-primary">Invite</button>
        </div>
    </form>
</main>
@endsection
