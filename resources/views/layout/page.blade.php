@extends('layout.master')

@section('title')
    @yield('page-title') | SagaOne
@endsection

@section('body')

    @include('component.topbar')

    <main class="page-content">
        <div class="container pt-5">

            @include('component.flashMessage')

            @yield('page-content')
        </div>
    </main>

    <div class="page-footer">
        @yield('page-footer')
    </div>
@endsection
