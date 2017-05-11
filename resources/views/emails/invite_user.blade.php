@extends('emails.layout')

@section('content')
    {{ config('app.name', 'Laravel') }}<br>
    {{$company->name}} invited you on Horizony<br>
    You 'll see the planning of the company<br>

    <a href="{{$user->generateUrlConnexion()}}">Go to your Horizon</a>


@endsection
