@extends('layouts.app')


@section('content')
    <div class="container">


        <div class="row">
            <div class="col-md-6">

                @foreach ($companies as $company)
                    <div class="col-md-8">
                        <div class="panel panel-default">
                            {{--<div class="panel-heading"></div>--}}

                            <div class="panel-body">
                               Company Name :  <a href="{{route('company_home',['company_key'=>$company->key])}}">{{$company->name}}</a><br>

                            </div>
                        </div>
                    </div>
                @endforeach

                @if(Auth::user()->companies()->count() == 0)
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            {{--<div class="panel-heading"></div>--}}

                            <div class="panel-body">
                                <a href="{{route('register_company')}}" class="btn btn-primary">Create a company</a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

@stop
