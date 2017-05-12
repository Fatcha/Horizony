@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-8 col-md-offset-2">
                <div class="panel">
                    <div class="row" style="padding: 20px;">
                        <div class="col-xs-12 ">
                            <h1 class='dark'>{{trans('department.create_title')}}</h1>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-10 col-lg-offset-1">
                            {!! Form::open(['url' => route('company_department_create_or_update',['company_key'=>$company->key,'cid'=>CryptId::cryptIdToHash($department->id)])]) !!}
                            <div class="form-group">
                                {!!   Form::text('name', $department->name, ['class' => 'form-control','placeholder'=> trans('department.placeholder_department_name')]) !!}
                                <br>
                                {!! $errors->first('name') !!}<br>
                                {!!   Form::submit(trans('department.button_validate'),['class' => 'btn btn-primary']) !!}

                            </div>
                            {!! Form::close() !!}

                            <a href="{{route('company_home',['company_key'=>$company->key])}}">Return to company page</a>

                        </div>


                    </div>


                </div>
            </div>
        </div>
    </div>

@stop