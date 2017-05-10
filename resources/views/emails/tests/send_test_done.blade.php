@extends('emails.layout')

@section('content')
    <h1>Step By Test</h1>
    <div>Test {{$quizUser->quiz->getLocaleField('title')}} has been  done by  {{$user->name}}</div>
    <br><br>
    <div><a href="{{route('connected_dashboard')}}">Go to the website</a></div>

@endsection
