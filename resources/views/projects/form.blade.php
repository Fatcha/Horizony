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
                            {!! Form::open(['url' => route('company_project_edit',['company_key'=>$company->key,'cid'=>CryptId::cryptIdToHash($project->id)])]) !!}
                            <div class="form-group">
                                {!!   Form::text('name', $project->name, ['class' => 'form-control','placeholder'=> trans('registration.placeholder_project_name')]) !!}
                                <br>
                                {!! $errors->first('name') !!}<br>

                                {!!   Form::text('job_number', $project->job_number, ['class' => 'form-control','placeholder'=> trans('registration.placeholder_project_name')]) !!}
                                <br>
                                {!! $errors->first('job_number') !!}<br>

                                {!!   Form::text('end_expectation', $project->end_expectation, ['class' => 'form-control','placeholder'=> trans('registration.placeholder_project_name')]) !!}
                                <br>
                                {!! $errors->first('end_expectation') !!}<br>
                                Project Manager:
                                {!! Form::select('user_pm_id', $users, $project->user_pm_id,['class' => 'form-control','placeholder'=> trans('registration.placeholder_project_name')]) !!}

                                <br>
                                Category:
                                {!! Form::select('category_id', $categories, $project->category_id,['class' => 'form-control','placeholder'=> trans('registration.placeholder_project_name')]) !!}

                                <br>
                                <div id="colorpicker" class="input-group colorpicker-component">
                                    {!!   Form::text('color', $project->color, ['class' => 'form-control','placeholder'=> trans('registration.placeholder_project_name'),'id' => '']) !!}
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