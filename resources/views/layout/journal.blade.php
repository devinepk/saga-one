@extends('layout.master')

@section('title')
    @yield('page-title') | SagaOne
@endsection

@section('body')
<div class="container-fluid">

    @include('component.topbar')

    <div class="below-topbar">

        <div class="row no-gutters">

            @include('component.sidebar')

            <main role="main" class="col-md-9 ml-sm-auto">

                @include('component.flashMessage')

                @yield('journal-content')

            </main>
        </div>
    </div>
</div>
@endsection
