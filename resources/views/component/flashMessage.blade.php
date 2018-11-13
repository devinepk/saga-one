@if ($errors->any())
    <div class="container">
        <alert level="warning">Please fix the errors below.</alert>
    </div>
@endif

@if (session('status'))
    <div class="container">
        <alert level="primary">{!! session('status') !!}</alert>
    </div>
@endif

@if (session('warning'))
    <div class="container">
        <alert level="warning">{!! session('warning') !!}</alert>
    </div>
@endif
