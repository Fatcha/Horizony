@extends('admin.layout')



@section('content')

    <div class="row">
        <div class="col-sm-5">
            {!! Form::model($quizQuestion, ['route' => ['admin_quiz_question_createOrUpdate','quizId'=>$quiz->id,'questionId'=>$quizQuestion->id]]) !!}


            <div class="panel panel-default">
                <div class="panel-heading">Question options</div>
                <div class="panel-body">
                    @if (session('error'))
                        <div class="alert alert-error">
                            {{ session('error') }}
                        </div>
                    @endif


                    {!! Form::hidden('quiz_id', $quiz->id) !!}
                    {!! Form::hidden('question_id', $quizQuestion->id) !!}
                    <div class="form-group">

                        <div class="form-group">
                            {{ Form::label('type_question', 'Type of question', ['class' => 'control-label ']) }}
                            @if(!$quizQuestion->id)
                                {{ Form::select('type_question', $typeAvailable,$quizQuestion->type_question,['class'=>'form-control ']) }}

                            @else

                                {{Form::text('type_question',$quizQuestion->type_question,['class'=>'form-control','disabled'=>'disabled'])}}
                            @endif


                        </div>
                        <div class="form-group">
                            {{ Form::label('active', null, ['class' => 'control-label']) }}
                            {!! Form::checkbox('active', 1,$quizQuestion->active ? true : false) !!}<br>
                        </div>
                        {!! Form::submit($quizQuestion->id ? 'Update':'Create',['class'=>'btn btn-warning']) !!}
                    </div>
                    <a href="{{route('admin_quiz_create_or_update',[$quiz,$quizQuestion])}}">return to question</a>
                </div>
            </div>
            @if($quizQuestion->id)


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
                                <div class="panel panel-default">

                                    <div class="panel-body">
                                {{ Form::label('question', "Question title", ['class' => 'control-label']) }}
                                {!! Form::textarea($key.'[question]', $quizQuestion->getLocaleField('question', $key),['class'=>'form-control','rows' => 3] ) !!}

                                <div class="picture_container {{!$quizQuestion->getLocaleField('picture_path',$key,'') ? 'hide' : '' }}">
                                    <a href="javascript:;" class="btn btn-danger delete-picture"
                                       data-cid="{{CryptId::cryptIdToHash($quizQuestion->id)}}"
                                       data-locale="{{$key}}"
                                       data-type="question">Delete picture</a>
                                    <img src="{{$quizQuestion->getLocaleField('picture_path',$key,'')}}"
                                         data-id="{{'question-'.$key.'-'.CryptId::cryptIdToHash($quizQuestion->id)}}"
                                         class="img-responsive">
                                </div>
                                        <br>
                                <input type="file"
                                       id="{{"ans-".$key."-".CryptId::cryptIdToHash($quizQuestion->id)}}"
                                       name="{{$key.'[question_'.CryptId::cryptIdToHash($quizQuestion->id).']'}}"
                                       class="file_upload"
                                       data-type="question"
                                       data-cid="{{CryptId::cryptIdToHash($quizQuestion->id)}}"
                                       data-locale="{{$key}}"/>
                                        <br>

                                {!! Form::submit($quizQuestion->id ? 'Update':'Create',['class'=>'btn btn-warning']) !!}


                                    </div>
                                </div>


                                <div class="panel panel-default">
                                    <div class="panel-heading">Answers</div>
                                    <div class="panel-body">

                                        <div class="form-group">
                                            @if(!empty($quizQuestion->id))
                                                {{ Form::label('Answers', null, ['class' => 'control-label']) }}
                                                add {{ Form::number('add_answer_number',1,['class'=>'small','min'=>'1','max'=>20,'size'=>1,'id'=>'answer-to-add'])}}
                                                <!--{{--href="<?php echo route('admin_quiz_question_add_answer', ['questionId' => $quizQuestion->id]);?>"--}}-->
                                                <button type="button"
                                                   class="btn btn-success btn-xs" onclick="window.location='<?php echo route('admin_quiz_question_add_answer', ['questionId' => $quizQuestion->id]);?>?nbr='+document.getElementById('answer-to-add').value;">answer</button>
                                                <ul id="answers_container" class="admin-answers">
                                                    @foreach( $answers as $answer)
                                                        <li class="<?php echo $answer->is_correct_answer ? 'bg-success' : ''; ?>">
                                                            <div class="form-group form-inline ">
                                                                {{--Management of correct answer--}}
                                                                <div class="panel  ">

                                                                    <div class="panel-body <?php echo $answer->is_correct_answer ? 'bg-green' : 'bg-blue'; ?> ">
                                                                        <div class="picture_container {{!$answer->getLocaleField('picture_path',$key,'')? 'hide' : '' }}">
                                                                            <a href="javascript:;"
                                                                               class="btn btn-danger delete-picture"
                                                                               data-cid="{{CryptId::cryptIdToHash($answer->id)}}"
                                                                               data-locale="{{$key}}"
                                                                               data-type="answer">Delete picture</a>
                                                                            <img src="{{$answer->getLocaleField('picture_path',$key,'')}}"
                                                                                 data-id="{{'answer-'.$key.'-'.CryptId::cryptIdToHash($answer->id)}}"
                                                                                 class="img-responsive">
                                                                        </div>
                                                                        @if($firstLanguage)
                                                                            @if( $quizQuestion->type_question == \App\Models\Quiz\QuizQuestion::TYPE_QUESTION_UNIQUE)
                                                                                {!!  Form::radio('answer_correct[]', $answer->id,$answer->is_correct_answer ? true:false) !!}
                                                                            @elseif ( $quizQuestion->type_question == \App\Models\Quiz\QuizQuestion::TYPE_QUESTION_MULTI)
                                                                                {!!  Form::checkbox('answer_correct[]', $answer->id,$answer->is_correct_answer ? true:false) !!}
                                                                            @endif
                                                                        @endif

                                                                        {!! Form::textarea($key.'[answer_id_'.$answer->id.']', $answer->getLocaleField('answer', $key),['class'=>'form-control ','id'=>'answer_'.$answer->id ,'rows' => 2,'cols'=>20]) !!}

                                                                        <?php echo $answer->is_correct_answer ? 'Correct Answer' : ''; ?>
                                                                        <br> <br>
                                                                        <input type="file"
                                                                               id="{{"ans-".$key."-".CryptId::cryptIdToHash($answer->id)}}"
                                                                               name="{{$key.'[answer_'.CryptId::cryptIdToHash($answer->id).']'}}"
                                                                               class="file_upload"
                                                                               data-type="answer"
                                                                               data-cid="{{CryptId::cryptIdToHash($answer->id)}}"
                                                                               data-locale="{{$key}}"/>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>


                                    </div>
                                </div>
                            </div>
                        <?php $firstLanguage = false ?>
                    @endforeach
                    {!! Form::submit($quizQuestion->id ? 'Update':'Create',['class'=>'btn btn-warning']) !!}
                    <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
            @endif
            {!! Form::close() !!}
        </div>
    </div>
    <script>
        var uploadQuestionFilePath = '{{route('admin_quiz_question_add_image')}}';
        var deleteQuestionFilePath = '{{route('admin_quiz_question_delete_image')}}';
    </script>
@endsection
