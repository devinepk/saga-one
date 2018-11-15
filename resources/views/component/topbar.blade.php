<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark text-light p-0 shadow">
    <a class="brand navbar-brand mx-3" href="{{ route('journal.index') }}"><span class="saga">Saga</span>one</a>

    <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#navMenu" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navMenu">

        {{-- Left Side Of Navbar --}}
        <ul class="navbar-nav mr-auto">

            @if (isset($journal))
            <li class="nav-item px-3">
                <a class="nav-link d-md-none text-light" href="{{ route('journal.show', $journal) }}"><font-awesome-icon :icon="['fab', 'readme']"></font-awesome-icon><span class="ml-2">{{ $journal->title }}</span></a>
            </li>
            @endif

        </ul>


        {{-- Right Side Of Navbar --}}
        <ul class="navbar-nav ml-auto">

            {{-- Authentication links --}}
            @auth
            <li class="nav-item dropdown px-3">

                {{-- Notifications --}}
                <a class="nav-link" id="notificationsLabel" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#"><font-awesome-icon icon="bell"></font-awesome-icon><span class="ml-2">Notifications</span><span class="badge badge-light rounded ml-2 align-text-bottom">1</span></a>

                <div class="dropdown-menu dropdown-menu-right px-3 py-2" aria-labelledby="notificationsLabel">
                    <p class="mb-0">Journal "Journal 1" is now in your possession!</p>
                </div>

            </li>

            <li class="nav-item dropdown px-3">

                {{-- User Menu --}}
                <a class="nav-link dropdown-toggle" id="userMenuLabel" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#"><font-awesome-icon icon="user"></font-awesome-icon><span class="ml-2">{{ Auth::user()->name }}</span></a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userMenuLabel">

                    <a class="dropdown-item" href="{{ route('journal.index') }}"><font-awesome-icon icon="book"></font-awesome-icon><span class="ml-2">Journals</span></a>

                    @can('create', App\Journal::class)
                        <a class="dropdown-item" href="{{ route('journal.create') }}"><font-awesome-icon icon="plus"></font-awesome-icon><span class="ml-2">Create a journal</span></a>
                    @endcan

                    <a class="dropdown-item" href="{{ route('invite.index') }}"><font-awesome-icon icon="mail-bulk"></font-awesome-icon><span class="ml-2">Invites</span></a>

                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item" href="{{ route('user.account') }}"><font-awesome-icon icon="user-circle"></font-awesome-icon><span class="ml-2">Account</span></a>

                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><font-awesome-icon icon="sign-out-alt"></font-awesome-icon><span class="ml-2">{{ __('Logout') }}</span></a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>

                </div>

            </li>

            @else

            {{-- Login and Register --}}
            <li class="nav-item px-3">
                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>

            <li class="nav-item px-3">
                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
            </li>
            @endauth
        </ul>
    </div>

</nav>

