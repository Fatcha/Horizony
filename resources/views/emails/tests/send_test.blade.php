@extends('emails.layout')

@section('content')
    <h1>{{ config('app.name', 'Laravel') }}</h1>
    <div>{{$company->name}} invited you on Horizony</div>
    <br><br>
    <div><a href="{{$user->generateUrlConnexion()}}">Go to test</a></div>

@endsection
