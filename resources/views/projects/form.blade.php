@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-8 col-md-offset-2">
                <div class="panel">
                    <div class="row" style="padding: 20px;">
                        <div class="col-xs-12 ">
                            <h1 class='dark'>{{trans('project.create.title')}}</h1>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-10 col-lg-offset-1">
                            {!! Form::open(['url' => route('company_project_edit',['company_key'=>$company->key,'cid'=>CryptId::cryptIdToHash($project->id)])]) !!}
                            <div class="form-group">
                                Project name:
                                {!!   Form::text('name', $project->name, ['class' => 'form-control','placeholder'=> trans('project.placeholder_project_name')]) !!}
                                <br>
                                {!! $errors->first('name') !!}<br>
                                Job number:
                                {!!   Form::text('job_number', $project->job_number, ['class' => 'form-control','placeholder'=> trans('project.placeholder_job_number')]) !!}
                                <br>
                                {!! $errors->first('job_number') !!}<br>
                                End Expectation:
                                {!!   Form::text('end_expectation', $project->end_expectation, ['class' => 'form-control','placeholder'=> trans('project.placeholder_end_expectation')]) !!}
                                <br>
                                {!! $errors->first('end_expectation') !!}<br>
                                Project Manager:
                                {!! Form::select('user_pm_id', $users, $project->user_pm_id,['class' => 'form-control']) !!}

                                <br>
                                Category:
                                {!! Form::select('category_id', $categories, $project->category_id,['class' => 'form-control']) !!}

                                <br>
                                Project color:
                                <div id="colorpicker" class="input-group colorpicker-component">
                                    {!!   Form::text('color', $project->color, ['class' => 'form-control','id' => '']) !!}
                                    <span class="input-group-addon"><i></i></span>
                                </div>
                                {!! $errors->first('color') !!}<br>

                                <br>


                                {!!   Form::submit(trans('registration.submit_form'),['class' => 'btn btn-primary']) !!}

                            </div>
                            {!! Form::close() !!}

                            <a href="{{route('company_home',['company_key'=>$company->key,'cid'=>CryptId::cryptIdToHash($project->id)])}}">Retour</a>


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