@extends('layout.home')

@section('title', 'SagaOne')

@section('content')
<main class="welcome">
    <section class="flex-center full-height position-relative">
        @auth
            <nav class="nav top-right welcome-links">
                <a href="{{ route('journal.index') }}" class="nav-link text-light">{{ __('auth.home') }}</a>
                <a class="nav-link text-light" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('auth.logout') }}</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
            </nav>
        @endauth

        <div>
            <h1 class="brand"><span class="saga">Saga</span>one</h1>

            @guest
                <nav class="nav welcome-links justify-content-around mt-4">
                    <a href="{{ route('login') }}" class="nav-link text-light">{{ __('auth.login') }}</a>
                    <a href="{{ route('register') }}" class="nav-link btn btn-outline-light font-weight-bold">{{ __('auth.register') }}</a>
                </nav>
            @endguest
        </div>
    </section>

    <section class="bg-dark p-5 mb-5 text-center shadow">
        <div class="row">
            <div class="col-md pb-5 mb-5 pb-md-0 mb-md-0">
                <font-awesome-icon icon="book" size="10x" class="d-block mx-auto mb-4"></font-awesome-icon>
                <span class="h5 text-secondary text-uppercase">Step 1</span>
                <h2>Create a journal</h2>
            </div>

            <div class="col-md pb-5 mb-5 pb-md-0 mb-md-0">
                <font-awesome-icon icon="users" size="10x" class="d-block mx-auto mb-4"></font-awesome-icon>
                <span class="h5 text-secondary text-uppercase">Step 2</span>
                <h2>Invite your friends</h2>
            </div>

            <div class="col-md">
                <font-awesome-icon icon="pencil-alt" size="10x" class="d-block mx-auto mb-4"></font-awesome-icon>
                <span class="h5 text-secondary text-uppercase">Step 3</span>
                <h2>Take turns writing</h2>
            </div>
        </div>
    </section>

    <section class="p-5">

            <div class="row justify-content-center py-5">
                <div class="col-md-3 col-lg-2 text-center">
                    <font-awesome-icon icon="sync-alt" size="8x" :rotation=90 class="d-block mx-auto mb-4"></font-awesome-icon>
                </div>
                <div class="col-md-9 col-lg-6">
                    <h2 class="text-secondary">Turn-based online journals</h2>
                    <p>Journals <strong class="text-secondary">automatically pass from person to person</strong> after a set period of time. For example, you can create a journal that rotates to the next user every day, every week, or every month.</p>
                </div>
            </div>

            <div class="row justify-content-center py-5">
                <div class="col-md-3 col-lg-2 text-center">
                    <font-awesome-icon :icon="['fab', 'readme']" size="8x" class="d-block mx-auto mb-4"></font-awesome-icon>
                </div>
                <div class="col-md-9 col-lg-6">
                    <h2 class="text-secondary">Read and write when it's your turn</h2>
                    <p>Only the person who has the journal can read it. When it's your turn with a journal, you can <strong class="text-secondary">write</strong> new entries, <strong class="text-secondary">read</strong> previous entries, and even <strong class="text-secondary">comment</strong> on previous entries.</p>
                </div>
            </div>

            <div class="row justify-content-center py-5">
                <div class="col-md-3 col-lg-2 text-center">
                    <font-awesome-icon :icon="['fab', 'connectdevelop']" size="8x" :rotation=90 class="d-block mx-auto mb-4"></font-awesome-icon>
                </div>
                <div class="col-md-9 col-lg-6">
                    <h2 class="text-secondary">Connect with others</h2>
                    <p>SagaOne leverages the power of the Internet to <strong class="text-secondary">create community regardless of distance</strong> but fosters a <strong class="text-secondary">small, intimate environment</strong>. It's a great way to share your life and build a sense of connection with others!</p>
                </div>
            </div>
    </section>

    <footer class="bg-dark pt-5 px-3 pb-2">
        <div class="row">
            <nav class="col-md nav justify-content-end welcome-links">
                @auth
                    <a href="{{ route('journal.index') }}" class="nav-link text-light">{{ __('auth.home') }}</a>
                    <a class="nav-link text-light" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('auth.logout') }}</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                @else
                    <a href="{{ route('login') }}" class="nav-link text-light">{{ __('auth.login') }}</a>
                    <a href="{{ route('register') }}" class="nav-link btn btn-outline-light font-weight-bold">{{ __('auth.register') }}</a>
                @endauth
            </nav>
        </div>

        <div class="mt-5 text-center text-white-50">
            <small>&copy; {{ now()->year }} SagaOne</small>
        </div>
    </footer>

</main>
@endsection
