@extends('layouts.app')



@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        User data
                    </div>
                    <div class="panel-body">


                        {!! Form::open(['url' => route('user_account_edit_save',[])]) !!}
                        <div class="form-group">
                            {!!   Form::text('name', $user->name, ['class' => 'form-control','placeholder'=> trans('registration.placeholder_company_name')]) !!}
                            <br>
                            <div class="label label-danger">{!! $errors->first('name') !!}</div>

                            {!!   Form::text('email', $user->email, ['class' => 'form-control','placeholder'=> '']) !!}
                            <div class="label label-danger">{!! $errors->first('email') !!}</div>
                            <br>
                            {!!   Form::submit('Validate',['class' => 'btn btn-primary']) !!}

                            <hr>
                            Change your password:<br>

                            <div class="form-group">
                                Password:<br>
                                {!!   Form::password('password', ['class' => 'form-control','placeholder'=> '']) !!}
                                <div class="label label-danger">{!! $errors->first('password') !!}</div>
                            </div>

                            <div class="form-group">
                                Password confirm:<br>
                                {!!   Form::password('password_confirmation', ['class' => 'form-control','placeholder'=> '']) !!}
                                <div class="label label-danger">{!! $errors->first('password_confirm') !!}</div>
                            </div>




                            <br>
                            {!!   Form::submit('Validate',['class' => 'btn btn-primary']) !!}


                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>

            </div>
            <!--<div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        LinkedIn Connect
                    </div>
                    <div class="panel-body">


                        @if(Auth::user()->linkedInProfile)
                            @if(Auth::user()->avatar())
                                <img  src="{{Auth::user()->avatar()}}" class=" img-rounded "><br>
                                {{Auth::user()->linkedInProfile->headline}}<br>
                            @endif
                        @else
                            <div class="text-center">
                                <a href="{{route('login_linkedin',['redirectUrl'=>'user_account_edit'])}}" class="btn btn-primary"><img src="/layout/social/linkedin-white-21px.png" > Connect</a><br>
                            </div>
                        @endif
                    </div>
                </div>

            </div>-->

        </div>
    </div>


@endsection
