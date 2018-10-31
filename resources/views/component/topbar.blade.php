<nav class="navbar navbar-expand-sm navbar-dark fixed-top bg-dark text-light p-0 shadow">
    <a class="brand navbar-brand mx-3" href="/"><span class="saga">Saga</span>one</a>

    @if ($journal)
        <a class="nav-link d-md-none text-light" href="/journal"><i class="fab fa-fw fa-readme mr-2"></i>{{ $journal['title'] }}</a>
    @endif

    <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#navMenu" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navMenu">
        <ul class="navbar-nav">
            <li class="nav-item dropdown px-3">
                <a class="nav-link" id="notificationsLabel" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#"><i class="fas fa-bell mr-2"></i>Notifications<span class="badge badge-light rounded ml-2 align-text-bottom">1</span></a>

                <div class="dropdown-menu dropdown-menu-right px-3 py-2" aria-labelledby="notificationsLabel">
                    <p class="mb-0">Journal "Journal 1" is now in your possession!</p>
                </div>


            </li>

            <li class="nav-item dropdown px-3">
                <a class="nav-link dropdown-toggle" id="userMenuLabel" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#"><i class="fas fa-user mr-2"></i>Bobby Bob</a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userMenuLabel">
                    <a class="dropdown-item" href="/user"><i class="fas fa-book fa-fw mr-2"></i>Journals</a>
                    <a class="dropdown-item" href="/journal/create"><i class="fas fa-plus fa-fw mr-2"></i>Create a journal</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt fa-fw mr-2"></i>Log out</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
