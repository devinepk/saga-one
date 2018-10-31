@extends('layout.home')

@section('title', 'SagaOne')

@section('content')
<main class="welcome flex-center full-height position-relative">
    <div>

        <h1 class="brand"><span class="saga">Saga</span>one</h1>

        <nav class="nav justify-content-around mt-4">
            <a href="{{ route('login') }}" class="nav-link text-light">Login</a>
            <a href="{{ route('register') }}" class="nav-link border text-light">Sign up</a>
        </nav class="nav justify-content-center">

    </div>
</main>
@endsection
