<div class="container">
    @if ($errors->any())
        <alert level="danger">Please fix the errors below.</alert>
    @endif

    @if (session('status'))
        <alert level="primary">{!! session('status') !!}</alert>
    @endif

    @if (session('warning'))
        <alert level="warning">{!! session('warning') !!}</alert>
    @endif

    @if (session('verified'))
        <alert level="primary">Thank you for verifying your email address!</alert>
    @endif
</div>
