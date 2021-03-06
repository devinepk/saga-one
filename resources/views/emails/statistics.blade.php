@extends('emails.layout')

@section('body')
    @component('emails.components.h1')
        Site Statistics
    @endcomponent

<hr>

    @component('emails.components.h2')
        Report date: {{ $report->meta->date }}
    @endcomponent

    @component('emails.components.h2')
        Environment level: {{ $report->environment->level }}
    @endcomponent

    @component('emails.components.h2')
        Environment name: {{ $report->environment->name }}
    @endcomponent

    @component('emails.components.h2')
        Site url: <a href="{{ $report->environment->url }}" style="color: #3869D4;">{{ $report->environment->url }}</a>
    @endcomponent

<hr>

<table style="text-align:left; color:black;">
    <tr>
        <th style="padding-right:10px;">Total registered users:</th>
        <td >{{ $report->total->users }}</td>
    </tr>
    <tr>
        <th style="padding-right:10px;">Total journals:</th>
        <td>{{ $report->total->journals }}</td>
    </tr>
    <tr>
        <th style="padding-right:10px;">Total entries:</th>
        <td>{{ $report->total->entries }}</td>
    </tr>
    <tr>
        <th style="padding-right:10px;">Total comments:</th>
        <td>{{ $report->total->comments }}</td>
    </tr>
    <tr>
        <th style="padding-right:10px;">Total invites sent:</th>
        <td>{{ $report->total->invites }}</td>
    </tr>
</table>
@endsection
