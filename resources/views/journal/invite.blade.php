@extends('layout.page')

@section('page-title', 'Invite a friend')

@section('page-content')
<main class="container p-md-5">
    <h1>Invite a friend to join {{ $journal['title'] }}</h1>
    <form method="post" action="">
        <div class="form-group my-5">
            <label for="email">Email address:</label>
            <input type="email" class="form-control" id="email" name="title">
        </div>

    </form>
</main>
@endsection
