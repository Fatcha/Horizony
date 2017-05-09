@extends('admin.layout')



@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">


                    {!! Form::open(['url' => route('admin_user_edit',['id' => $user->id])]) !!}
                    <div class="form-group">
                        {!!   Form::text('name', $user->name, ['class' => 'form-control','placeholder'=> trans('registration.placeholder_company_name')]) !!}
                        <br>
                        {!! $errors->first('name') !!}<br>
                        {!!   Form::text('email', $user->email, ['class' => 'form-control','placeholder'=> '']) !!}
                        <br>
                        {!! $errors->first('email') !!}<br>

                        {!!   Form::submit('Validate',['class' => 'btn btn-primary']) !!}


                    </div>
                    {!! Form::close() !!}
                </div>
            </div>

        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-body">




                </div>
            </div>

        </div>
        </div>



@endsection
