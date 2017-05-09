@extends('admin.layout')



@section('content')

    <div class="row">
        <div class=" col-sm-8">
                <h3>{{$quiz->title}} updated</h3>
                Question created : {{$arrayResult['questions_created']}}<br>
                Answer created : {{$arrayResult['answers_created']}}<br>

        </div>
    </div>

@endsection
