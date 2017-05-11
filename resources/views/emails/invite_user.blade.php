@extends('emails.layout')

@section('content')
    <h1>{{ config('app.name', 'Laravel') }}</h1>
    <div>{{$company->name}} invited you on Horizony</div>
    <div>You 'll see the planning of the company</div>

    <div><a href="{{$user->generateUrlConnexion()}}">Go to your Horizon</a></div>

@endsection
