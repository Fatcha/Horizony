@extends('admin.layout')



@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">


                    {!! Form::open(['url' => route('admin_company_edit',['id' => $company->id])]) !!}
                    <div class="form-group">
                        {!!   Form::text('name', $company->name, ['class' => 'form-control','placeholder'=> trans('registration.placeholder_company_name')]) !!}
                        <br>
                        {!! $errors->first('name') !!}<br>

                        {!! Form::select('country', $countriesList,$company->country_code,  ['class' => 'form-control']) !!}
                        <br>
                        {!! $errors->first('country') !!}<br>
                        {!!   Form::submit(trans('registration.submit_form'),['class' => 'btn btn-primary']) !!}


                    </div>
                    {!! Form::close() !!}
                </div>
            </div>

        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-body">
                    Number of tests sent : {{$company->tests->count()}}
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-body">

                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>
                                Name
                            </th>
                            <th>

                            </th>
                            <th>

                            </th>

                        </tr>

                        </thead>

                        @foreach($users as $user)

                            <tr>
                                <td>
                                    {{$user->name}}
                                </td>
                                <td>
                                    {{$user->pivot->role}}
                                </td>
                                <td>

                                </td>

                            </tr>
                        @endforeach
                    </table>

                </div>
            </div>
        </div>



@endsection
