@extends('layout.master')

@section('title')
    @yield('page-title') | SagaOne
@endsection

@section('body')
<div class="container-fluid">
    @include('component.topbar')
    <div class="below-topbar">
        @yield('page-content')
    </div>
</div>
@endsection
