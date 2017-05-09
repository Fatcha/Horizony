@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-8 col-md-offset-2">
                <div class="panel">
                    <div class="row" style="padding: 20px;">
                        <div class="col-xs-12 ">
                            <h1 class='dark'>{{trans('registration.title')}}</h1>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-10 col-lg-offset-1">
                            {!! Form::open(['url' => route('register_save')]) !!}
                            <div class="form-group">
                                {!!   Form::text('name', '', ['class' => 'form-control','placeholder'=> trans('registration.placeholder_company_name')]) !!}
                                <br>
                                {!! $errors->first('name') !!}<br>

                                {!! Form::select('country', $countriesList,null,  ['class' => 'form-control']) !!}<br>
                                {!! $errors->first('country') !!}<br>
                                {!!   Form::submit(trans('registration.submit_form'),['class' => 'btn btn-primary']) !!}


                            </div>
                            {!! Form::close() !!}



                        </div>


                    </div>


                </div>
            </div>
        </div>
    </div>
@stop