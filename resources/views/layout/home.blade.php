@extends('layout.master')

@section('title')
    @yield('title')
@endsection

@section('content')
    @parent
    <div class="container">
        @yield('content')
    </div>
@endsection
