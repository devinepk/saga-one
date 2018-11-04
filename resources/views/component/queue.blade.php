@foreach ($journal->queue as $user)

    <li class="list-group-item list-group-item-action">

        <font-awesome-icon icon="user"></font-awesome-icon>
        <span class="ml-2">{{ $user->name }}</span>

    </li>

@endforeach
