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
                            {!! Form::open(['url' => route('company_project_cat_edit',['company_key'=>$company->key,'cid'=>CryptId::cryptIdToHash($category->id)])]) !!}
                            <div class="form-group">
                                {!!   Form::text('name', $category->name, ['class' => 'form-control','placeholder'=> trans('registration.placeholder_project_name')]) !!}
                                <br>
                                {!! $errors->first('name') !!}<br>


                                <div id="colorpicker" class="input-group colorpicker-component">
                                    {!!   Form::text('color', $category->color, ['class' => 'form-control','placeholder'=> trans('registration.placeholder_project_name'),'id' => '']) !!}
                                    <span class="input-group-addon"><i></i></span>
                                </div>
                                {!! $errors->first('color') !!}<br>

                                <br>


                                {!!   Form::submit(trans('registration.submit_form'),['class' => 'btn btn-primary']) !!}

                            </div>
                            {!! Form::close() !!}



                        </div>


                    </div>


                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            $('#colorpicker').colorpicker();
        });
    </script>
@stop