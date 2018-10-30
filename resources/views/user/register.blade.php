@extends('layout.home')

@section('title', 'Sign up | SagaOne')

@section('content')
<main class="d-flex justify-content-center">
    <div class="card w-50 p-5 my-5">
        <h1 class="mb-4">Sign up</h1>
        <form method="post">
            <div class="form-group mb-4">
                <label for="first_name">First name</label>
                <input type="text" id="first_name" name="first_name" class="form-control">
            </div>

            <div class="form-group mb-4">
                <label for="last_name">Last name</label>
                <input type="text" id="last_name" name="last_name" class="form-control">
            </div>

            <div class="form-group mb-4">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control">
            </div>

            <div class="form-group mb-4">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control">
            </div>

            <div class="form-group mb-4">
                <label for="password_confirm">Confirm password</label>
                <input type="password" id="password_confirm" name="password_confirm" class="form-control">
            </div>

            <button type="submit" class="btn btn-block btn-secondary">Sign me up!</button>
        </form>
    </div>
</main>
@endsection
