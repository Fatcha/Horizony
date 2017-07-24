@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-8 col-md-offset-2">
                <div class="panel">
                    <div class="row" style="padding: 20px;">
                        <div class="col-xs-12 ">
                            <h1 class='dark'>{{trans('member.edit.role')}} {{$user->name}}</h1>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-10 col-lg-offset-1">
                            {!! Form::open(['url' => route('company_edit_member',['company_key'=>$company->key,'cid'=>CryptId::cryptIdToHash($user->id)]),'action'=>'POST','class'=>'form-horizontal']) !!}



                            <div class="form-group">
                                <label for="role" class="col-sm-2 control-label">Role</label>
                                <div class="col-sm-10">
                                    {{ Form::select('role', $rolesArray, $userPivot->pivot->role, ['class' => 'form-control input-sm'])}}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="role" class="col-sm-2 control-label">Department</label>
                                <div class="col-sm-10">
                                    {{ Form::select('department_id', $departments, $userPivot->pivot->department_id, ['class' => 'form-control input-sm'])}}
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    {!! Form::submit('Validate',['class' => 'btn btn-primary']) !!}
                                </div>
                            </div>
                            {{ Form::close() }}

                            <a href="{{route('company_home',['company_key'=>$company->key])}}">Return to company page</a>


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