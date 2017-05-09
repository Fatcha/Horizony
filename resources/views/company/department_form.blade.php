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
                            {!! Form::open(['url' => route('company_department_create_or_update',['company_key'=>$company->key,'cid'=>CryptId::cryptIdToHash($department->id)])]) !!}
                            <div class="form-group">
                                {!!   Form::text('name', $department->name, ['class' => 'form-control','placeholder'=> trans('registration.placeholder_project_name')]) !!}
                                <br>
                                {!! $errors->first('name') !!}<br>






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