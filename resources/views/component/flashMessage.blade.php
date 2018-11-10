@if (session('status'))
<div class="container">
    <alert level="primary">{!! session('status') !!}</alert>
</div>
@endif
