@extends('layouts.app')



@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        User data
                    </div>
                    <div class="panel-body">
                        <div class="text-center">
                            <a href="{{route('login_linkedin')}}" class="btn btn-primary"><img src="/layout/social/linkedin-white-21px.png" > Connect</a><br>
                        </div>
                        <div class="pull-right">
                            <a href="{{route('connected_dashboard')}}" class="">skip step >></a>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>


@endsection
