@extends('layouts.app')


@section('content')
    <div class="container">


        <div class="row">
            <div class="col-sm-12 col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">Company Name</div>
                    <div class="panel-body">
                        {{$company->name}}<br>
                        Version type : {{ trans('account.type_'.$company->getCurrentAccount()->key_name) }}
                        <div><a href="{{route('company_account_home',[$company->key])}}">Change account</a></div>
                    </div>
                </div>

            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div><a href="{{route('company_planning_date',[$company->key])}}" class="btn btn-primary">View planning</a></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">Company's projects</div>
                    <div class="panel-body">
                        <div class="overflow-500px">
                            <table class="table table-responsive table-striped">
                                <thead>
                                    <tr>
                                        <th colspan="2">Name</th>
                                        <th>Job Number</th>
                                        <th>Category</th>
                                        <th>
                                            @if($isAdmin)
                                            <a href="{{route('company_project_edit',['company_key'=>$company->key])}}" class="btn btn-primary btn-xs pull-right"><span class="glyphicon glyphicon-plus"></span></a></th>
                                            @endif
                                    </tr>
                                </thead>

                                <tbody>
                                @foreach ($company->projects as $project)
                                    <tr>
                                        <td style="width: 30px">
                                            <div style="background-color: {{$project->colorCategoryOrProject()}}; width: 22px"> &nbsp;</div>
                                        </td>
                                        <td>{{$project->name}}</td>
                                        <td>{{$project->job_number}}</td>
                                        <td>{{$project->category->name}}</td>
                                        <td>
                                            @if($isAdmin)
                                            <a
                                               href="{{route('company_project_edit',['company_key'=>$company->key,'cid'=>CryptId::cryptIdToHash($project->id)])}}"
                                               class="btn btn-default btn-xs pull-right"><span class="glyphicon glyphicon-pencil"></span></a>
                                            @endif
                                        </td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">Company's clients</div>
                    <div class="panel-body">
                        <div class="overflow-500px">
                            <table class="table table-responsive table-striped">
                                <thead>
                                    <tr>
                                        <th colspan="2">Name</th>
                                        <th>
                                            @if($isAdmin)
                                                <a href="{{route('company_project_cat_edit',['company_key'=>$company->key])}}"
                                                   class="btn btn-primary btn-xs pull-right"><span class="glyphicon glyphicon-plus"></span></a>
                                            @endif
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                @foreach ($company->projectsCategories as $category)
                                    <tr>
                                        <td style="width: 30px"><div style="background-color: {{$category->color}}; width: 22px;">&nbsp;</div></td>
                                        <td>{{$category->name}}</td>
                                        <td>
                                            @if($isAdmin)
                                            <a
                                               href="{{route('company_project_cat_edit',['company_key'=>$company->key,'cid'=>CryptId::cryptIdToHash($category->id)])}}"
                                               class="btn btn-default btn-xs pull-right"><span class="glyphicon glyphicon-pencil"></span></a>
                                                @endif
                                        </td>

                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Company's users
                        @if($isAdmin && !session('number_of_users_already_reached'))
                            <a class="btn btn-primary btn-xs pull-right" data-toggle="collapse" href="#invite_member"><span class="glyphicon glyphicon-plus"></span></a>
                        @endif
                    </div>

                    <div class="panel-body collapse" id="invite_member">
                        @if (session('number_of_users_already_reached'))
                            <div class="alert alert-danger">
                                You have already reached the number of users your limit is
                                : {{$company->accountType->users_limit}}  {{str_plural('user',$company->accountType->users_limit)}}
                            </div>
                        @endif


                        @if($isAdmin)
                            {!! Form::open(['url' => route('company_invite_member',[$company->key]),'action'=>'POST','class'=>'form-horizontal']) !!}
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Name</label>
                                <div class="col-sm-10">
                                    {!! Form::text('name', '', ['class' => 'form-control input-sm','placeholder'=>'Full name']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email" class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-10">
                                    {!! Form::text('email', '', ['class' => 'form-control input-sm','placeholder'=>'Email']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="role" class="col-sm-2 control-label">Role</label>
                                <div class="col-sm-10">
                                    {{ Form::select('role', $rolesArray, null, ['class' => 'form-control input-sm'])}}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="role" class="col-sm-2 control-label">Role</label>
                                <div class="col-sm-10">
                                    {{ Form::select('department_id', $departments, null, ['class' => 'form-control input-sm'])}}
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    {!! Form::submit('Send invitation',['class' => 'btn btn-primary']) !!}
                                </div>
                            </div>
                            {{ Form::close() }}
                        @else
                            <p class="bg-info">You have to be admin of the company to manage users</p>
                        @endif
                    </div>

                    <div class="panel-body">
                        <div class="overflow-500px">
                        <table class="table table-responsive table-striped">
                            <thead>
                            <tr>
                                <th>User</th>
                                <th colspan="3">Role</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($company->users as $user)
                                <tr>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->pivot->role}}</td>
                                    <td>{{$user->pivot->department_id}}</td>
                                    <td>
                                        @if($user->id != Auth::user()->id && $isAdmin)
                                            <a href="{{route('company_delete_member',['company_key'=>$company->key,'userCid'=> CryptId::cryptIdToHash($user->id)])}}" class="btn btn-danger btn-xs pull-right" onclick="return confirm('Are you sure you want to remove this member?')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">Company's departments</div>
                    <div class="panel-body">
                        <div class="overflow-500px">
                            <table class="table table-responsive table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Members</th>
                                        <th>
                                            @if($isAdmin)
                                            <a href="{{route('company_department_create_or_update',['company_key'=>$company->key])}}"
                                               class="btn btn-primary btn-xs pull-right"><span class="glyphicon glyphicon-plus"></span></a>
                                        @endif
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                @foreach ($company->departments as $department)
                                    <tr>
                                        <td>{{$department->name}}</td>
                                        <td>{{count($department->users)}}</td>
                                        <td>
                                            @if($isAdmin)
                                            <a
                                               href="{{route('company_department_create_or_update',['company_key'=>$company->key,'cid'=>CryptId::cryptIdToHash($department->id)])}}"
                                               class="btn btn-default btn-xs pull-right"><span class="glyphicon glyphicon-pencil"></span></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
