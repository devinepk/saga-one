@extends('layout.page')

@section('page-title', 'Account')

@section('page-content')
<main class="container">
    <h1 class="my-5">Your account</h1>

    <div class="row">
        <div class="col-md-4">
            <div class="card mb-5">
                <img class="card-img-top">
                    <button class="btn btn-secondary">Upload profile picture</button>
            </div>
        </div>
        <div class="col-md">
            <form class="container" method="post" action="">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input id="name" name="name" type="text" class="form-control" value="Bobby Bob">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" class="form-control" value="bobby@example.com">
                </div>

                <div class="form-group">
                    <label for="timezone">Time Zone</label>
                    <select id="timezone" name="timezone" class="form-control">
                        <option selected>America/New York</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Update profile</button>
            </form>
        </div>
    </div>
</main>
@endsection
