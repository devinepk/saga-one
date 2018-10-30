@extends('layout.home')

@section('title', 'SagaOne')

@section('content')
<main class="welcome flex-center full-height">
    <h1 class="brand"><span class="saga">Saga</span>one</h1>
    <nav class="nav">
        <a href="/login" class="nav-link text-light">Login</a>
        <a href="/signup" class="nav-link text-light">Sign up</a>
    </nav>
</main>
@endsection
