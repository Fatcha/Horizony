@extends('admin.layout')



@section('content')

    <div class="row">
        <div class="col-sm-5">
            {!! Form::open(['url'=>route('admin_quiz_create_or_update',['quizId'=>$quiz->id])]) !!}
            {!! Form::hidden('quiz_id', $quiz->id) !!}
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <?php $firstLanguage = true ?>
                    @foreach($availableLocales as $key => $value)
                        <li class="{{$firstLanguage ? 'active' : ''}}"><a href="#tab_{{$key}}"
                                                                          data-toggle="tab">{{$value}}</a></li>
                        <?php $firstLanguage = false ?>
                    @endforeach

                    <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                </ul>
                <div class="tab-content">
                    <?php $firstLanguage = true ?>
                    @foreach($availableLocales as $key => $value)

                        <div class="tab-pane {{$firstLanguage ? 'active' : ''}}" id="tab_{{$key}}">
                            <div class="form-group">
                                {{ Form::label('Title', null, ['class' => 'control-label']) }}
                                {!! Form::text($key.'[title]', $quiz->getLocaleField('title', $key),['class'=>'form-control']) !!}
                            </div>
                            <div class="form-group">
                                {{ Form::label('Title', null, ['class' => 'control-label']) }}
                                {!! Form::textarea($key.'[description]', $quiz->getLocaleField('description', $key),['class'=>'form-control']) !!}
                            </div>
                        </div>
                    <?php $firstLanguage = false ?>
                @endforeach
                {!! Form::submit($quiz->id? 'Update':'Create',['class'=>'btn btn-success']) !!}
                <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>


            {!! Form::close() !!}


        </div>
        <div class="col-sm-5">


            <?php
            if(!empty($quiz->id)){

            $questions = $quiz->questions;
            ?>

            <div class="row">
                <div class="col-xs-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">Export Xls file</div>
                        <div class="panel-body">
                            <a href="{{route('admin_quiz_export_quiz',['quiz_id'=> $quiz->id])}}"
                               class="btn btn-success">Export as xls</a>

                        </div>
                    </div>
                </div>

                <div class="col-xs-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">Upload batch questions</div>
                        <div class="panel-body">
                            {!! Form::open(['url' => route('admin_quiz_upload_question',['quizId'=>$quiz->id]), 'method' => 'post' ,'files' => true]) !!}
                            {!! Form::file('xls') !!}
                            {!! Form::submit('Upload',['class'=>'btn btn-primary']) !!}
                            {!! Form::close() !!}

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <hr>
                <div class="panel panel-default">
                    <div class="panel-heading">List of Questions</div>
                    <div class="panel-body">
                    <div class="table-responsive">
                         <a class="btn btn-success btn-xs" href="<?php echo route('admin_quiz_question_createOrUpdate', ['qid' => $quiz->id]); ?>">Create a new
                             question</a>
                        <table class="table ">
                            <tr>
                                <td>#</td>
                                <td>Question</td>
                                <td>Success rate</td>
                                <td>Difficulty</td>
                                <td>Edit</td>
                            </tr>
                            <?php
                            $nbr = 0;
                            foreach ($questions as $question){
                            ?>
                            <tr class="<?php echo $question->active ? 'bg-success' : 'bg-danger'?>">
                                <td><?php echo ++$nbr;?></td>
                                <td>{{$question->getLocaleField('question')}} </td>
                                <td>{{$question->getRateInPourcent()}}% </td>
                                <td>{{$question->level}} </td>
                                <td>
                                    <a class="btn btn-warning btn-xs"
                                       href="<?php echo route('admin_quiz_question_createOrUpdate', ['qid' => $quiz->id, 'quizId' => $question->id]); ?>">Edit</a>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                        </table>
                    </div>
                </div>
                </div>

            </div>
            <?php
            }
            ?>
        </div>
    </div>

    <script>
        function updateAnswer(id) {
           /* $.ajax({
                url: '<?php // echo route('admin_quiz_question_update_answer');?>',
                type: 'POST',
                data: {answerId: id, answer: $('#answer_' + id).val()}

            });*/
        }

        document.addEventListener("DOMContentLoaded", function (event) {
            $('.correct_radio').click(function () {
                console.log($(this).attr("data-id"));

                setCorrectAnswer($(this).attr("data-id"))
            })
        });
        function setCorrectAnswer(id) {

            $.ajax({
                url: '<?php //echo route('admin_quiz_question_set_correct_answer');?>',
                type: 'POST',
                data: {answerId: id}

            });
        }
    </script>
@endsection
