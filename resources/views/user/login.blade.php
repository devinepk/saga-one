@extends('layout.home')

@section('title', 'Log in | SagaOne')

@section('content')
<main class="flex-center full-height">
    <div class="card w-50 p-5">
        <h1 class="mb-4">Log in</h1>
        <form method="post">
            <div class="form-group mb-4">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control">
            </div>

            <div class="form-group mb-4">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control">
            </div>

            <button type="submit" class="btn btn-block btn-secondary">Log in</button>
        </form>
    </div>
</main>
@endsection
