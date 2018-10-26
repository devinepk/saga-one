@extends('layout.master')

@section('title')
    @yield('page-title') | SagaOne
@endsection

@section('body')
<div class="container-fluid">

    @include('component.topbar')

    <div class="row no-gutters">
        @include('component.sidebar')

        <main role="main" class="col-md-9 ml-sm-auto">
            @yield('page-content')
        </main>
    </div>
</div>
@endsection
