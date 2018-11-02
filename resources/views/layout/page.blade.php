@extends('layout.master')

@section('title')
    @yield('page-title') | SagaOne
@endsection

@section('body')
<div class="container-fluid">

    @include('component.topbar')

    <div class="below-topbar">
        <main class="container">

        @include('component.flashMessage')

        @yield('page-content')

        </main>
    </div>
</div>
@endsection
