@extends('layout.page')

@section('page-content')
<div class="row no-gutters">
    @include('component.sidebar')

    <main role="main" class="col-md-9 ml-sm-auto">
        @yield('journal-content')
    </main>
</div>
@endsection
