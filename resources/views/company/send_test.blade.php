@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Register</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST"
                              action="{{ route('company_send_test_save',[$company->key]) }}">
                            {{ csrf_field() }}

                            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name"
                                           value="{{ old('name') }}">
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-6 ">
                                    <input id="email" type="text" class="form-control" name="email"
                                           value="{{ old('email') }}">

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>


                            </div>


                            <div class="form-group ">
                                <label class="col-md-4 control-label">Choose tests to send</label>
                                <div class="col-md-6 ">

                                    <div class="" style="max-height: 300px;overflow: auto;">
                                        <ul id="check-list-box" class="list-group checked-list-box">
                                            @if (session('selectedTests'))
                                                <div class="alert alert-danger">
                                                    {{ session('selectedTests') }}
                                                </div>
                                            @endif

                                            @foreach ($testsAvailable as $test)
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-xs-12">
                                                            <label class="form-check-label">
                                                                @if($test->isTestAvailableWithAccount($company))
                                                                    {{ Form::checkbox('test_selected[]', CryptId::cryptIdToHash($test->id)) }}
                                                                @endif

                                                                {{$test->getLocaleField('title')}}
                                                                    @if(!$test->isTestAvailableWithAccount($company))
                                                                        <br><small class="label label-warning">Not available with this account</small>
                                                                    @endif

                                                            </label><br>
                                                                 Questions: {{count($test->questions)}}


                                                        </div>

                                                    </div>


                                                </li>
                                            @endforeach


                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('nbr_of_questions') ? ' has-error' : '' }}" >
                                <label class="col-md-4 control-label">Options for these tests</label>
                                <div class="col-md-6 ">
                                    Number of questions (bewteend 5 and 100):<br>
                                    <small>If the number of question is greater than the number total question for this test. It will take the value of max number of questions.</small>
                                    {{ Form::number('nbr_of_questions', old('nbr_of_questions') ? old('nbr_of_questions') : 40,['class'=>'form-control','min'=>'5','max'=>100,'size'=>2])}}

                                    @if ($errors->has('nbr_of_questions'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('nbr_of_questions') }}</strong>
                                        </span>
                                    @endif

                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('nbr_of_questions') ? ' has-error' : '' }}" >
                                <label class="col-md-4 control-label"></label>
                                <div class="col-md-6 ">
                                    Time by question (in seconds):{{ Form::number('time_by_question', old('time_by_question') ? old('time_by_question') : 15,['class'=>'form-control','min'=>'5','max'=>200,'size'=>2])}}
                                    @if ($errors->has('time_by_question'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('time_by_question') }}</strong>
                                        </span>
                                    @endif

                                </div>
                            </div><div class="form-group " >
                                <label class="col-md-4 control-label"></label>
                                <div class="col-md-6 ">
                                    {{ Form::checkbox('can_see_result',1, old('can_see_result'),['class'=>''])}}
                                    User can see result

                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Send question
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
