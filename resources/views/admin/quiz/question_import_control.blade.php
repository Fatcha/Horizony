@extends('admin.layout')



@section('content')

    <div class="row">
        <div class=" col-sm-8">
            {!! Form::open(['url'=>route('admin_quiz_do_upload_question',['quizId'=>$quiz->id])]) !!}
            {!! Form::submit('Confirm',['class' => 'btn btn-primary']) !!}
            @foreach( $importedQuestions as $locale)
                <h4>Language: {{config('app.locales')[$locale['locale_key']]}}</h4>

                <table class="table">
                    <tr>
                        <td>ext-id</td>
                        <td>question_type</td>
                        <td>question</td>
                        @for($i = 0 ; $i < 10 ;$i++)
                           <td> {{'answer_'.$i}}</td>
                        @endfor

                    </tr>
                    @foreach($locale['questions'] as $question)
                        <tr class="{{empty($question['question']) ?'bg-danger' :''}}">
                            <td>{{$question['outside_key']}}
                                {!! Form::checkbox('questions[]',json_encode($question),empty($question['question']) ? false : true) !!}
                            </td>
                            <td>{{$question['question_type']}}</td>

                            <td class="{{empty($question['question']) ?'bg-danger' :'bg-info'}}">{{$question['question']}}</td>
                            @for($i = 0 ; $i < 10 ;$i++)
                                <td class="{{$i == 0 ?'bg-success' :''}} "> {{$question['answer_'.$i]}}</td>
                            @endfor
                        </tr>
                        @endforeach
                </table>

            @endforeach
            {!! Form::submit('Confirm',['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>
    </div>

@endsection
