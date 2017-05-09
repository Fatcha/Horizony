@extends('admin.layout')



@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">

                    Account type : {{$account->key_name}}
                    {!! Form::open(['url' => route('admin_account_edit',['id' => $account->id])]) !!}
                    <div class="form-group">

                        {{ Form::label('users_limit', 'Users limit', ['class' => 'control-label ']) }}
                        {!!   Form::text('users_limit', $account->users_limit, ['class' => 'form-control','placeholder'=> trans('registration.users_limit')]) !!}
                        <br>
                        {!! $errors->first('users_limit') !!}<br>
                        {{ Form::label('real_price', 'Price in ', ['class' => 'control-label ']) }}
                        {!!   Form::text('real_price', $account->real_price, ['class' => 'form-control','placeholder'=> trans('registration.real_price')]) !!}
                        <br>
                        {!! $errors->first('real_price') !!}<br>


                        {{ Form::label('max_tests_in_progress', 'Max tests in progress ', ['class' => 'control-label ']) }}
                        {!!   Form::text('max_tests_in_progress', $account->max_tests_in_progress, ['class' => 'form-control','placeholder'=> trans('registration.real_price')]) !!}
                        <br>
                        {!! $errors->first('max_tests_in_progress') !!}<br>


                        {!!   Form::submit('Validate',['class' => 'btn btn-primary']) !!}


                    </div>
                    {!! Form::close() !!}
                </div>
            </div>

        </div>

    </div>



@endsection
