@extends('emails.layout')

@section('body')
<h1>Site Statistics</h1>

<hr>

    <h2>Report date: {{ $report->meta->date }}</h2>
    <h2>Environment level: {{ $report->environment->level }}</h2>
    <h2>Environment name: {{ $report->environment->name }}</h2>
    <h2>Site url: <a href="{{ $report->environment->url }}">{{ $report->environment->url }}</a></h2>

<hr>

<table style="text-align:left; color:black; width:100%;">
    <tr>
        <th style="width:50%;">Total registered users:</th>
        <td>{{ $report->total->users }}</td>
    </tr>
    <tr>
        <th>Total journals:</th>
        <td>{{ $report->total->journals }}</td>
    </tr>
    <tr>
        <th>Total entries:</th>
        <td>{{ $report->total->entries }}</td>
    </tr>
    <tr>
        <th>Total comments:</th>
        <td>{{ $report->total->comments }}</td>
    </tr>
    <tr>
        <th>Total invites sent:</th>
        <td>{{ $report->total->invites }}</td>
    </tr>
</table>
@endsection
