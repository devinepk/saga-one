@extends('layout.master')

@section('title')
    @yield('page-title') | SagaOne
@endsection

@section('body')

    @include('component.topbar')

        <div class="page-content row no-gutters">

            @include('component.sidebar')

            <main role="main" class="journal-content col-md-9 ml-sm-auto pt-4">

                @include('component.flashMessage')

                @yield('journal-content')

            </main>
        </div>
@endsection
