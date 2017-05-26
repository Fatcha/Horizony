@extends('layouts.app')


@section('content')
    <div class="container">


        <div class="row">
            <div class="col-md-4">
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

            {{--Company's users--}}

            <div class="col-md-8">

                <div class="panel panel-default">
                    <div class="panel-heading">Company's users</div>

                    <div class="panel-body">
                        @if (session('number_of_users_already_reached'))
                            <div class="alert alert-danger">
                                You have already reached the number of users your limit is
                                : {{$company->accountType->users_limit}}  {{str_plural('user',$company->accountType->users_limit)}}
                            </div>
                        @endif
                        @if($isAdmin)
                            {!! Form::open(['url' => route('company_invite_member',[$company->key]),'action'=>'POST','class'=>'form-inline']) !!}
                            <div class="form-group">
                                <label for="name">Name</label>

                                {!!   Form::text('name', '', ['class' => 'form-control input-sm','placeholder'=>'Full name']) !!}
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                {!!   Form::text('email', '', ['class' => 'form-control input-sm','placeholder'=>'Email']) !!}
                            </div>
                            <div class="form-group">
                                <label for="role">Role</label>
                                {{Form::select('role', $rolesArray, null, ['class' => 'form-control input-sm'])}}
                            </div>
                                <div class="form-group">
                                    <label for="role">Role</label>
                                    {{Form::select('department_id', $departments, null, ['class' => 'form-control input-sm'])}}
                                </div>

                            {!!   Form::submit('Send invitation',['class' => 'btn btn-default btn-sm']) !!}
                            {{ Form::close() }}
                        @else
                            <p class="bg-info">You have to be admin of the company to manage users</p>
                        @endif
                        <table class="table table-responsive table-striped">
                            <thead>
                            <tr>

                                <th>User</th>
                                <th>Role</th>
                                <th></th>

                            </tr>
                            </thead>
                            <tbody>

                            @foreach ($company->users as $user)
                                <tr>
                                    <td>
                                        <small>{{$user->name}}</small>
                                    </td>
                                    <td>
                                        <small>{{$user->pivot->role}}</small>
                                    </td>

                                    <td>
                                        <small>{{$user->pivot->department_id}}</small>
                                    </td>
                                    <td>
                                        @if($user->id != Auth::user()->id && $isAdmin)
                                            <a href="{{route('company_delete_member',['company_key'=>$company->key,'userCid'=>CryptId::cryptIdToHash($user->id)])}}"
                                               class="btn btn-danger btn-sm">Delete</a>
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

        <div class="panel panel-default">
            <div class="panel-heading">Company's projects</div>

            <div class="panel-body">
                <table class="table table-responsive table-striped">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Project Name</th>
                        <th>Job Number</th>
                        <th>Category</th>

                        <th>
                            @if($isAdmin)
                            <a href="{{route('company_project_edit',['company_key'=>$company->key])}}"
                               class="btn btn-success btn-sm">Add</a></th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($company->projects as $project)
                        <tr>
                            <td>
                                <div style="background-color: {{$project->colorCategoryOrProject()}}"> &nbsp;</div>
                            </td>
                            <td>
                                <small>{{$project->name}}</small>
                            </td>
                            <td>
                                <small>{{$project->job_number}}</small>
                            </td>
                            <td>
                                <small>{{$project->category->name}}</small>
                            </td>
                            <td>
                                @if($isAdmin)
                                <a
                                   href="{{route('company_project_edit',['company_key'=>$company->key,'cid'=>CryptId::cryptIdToHash($project->id)])}}"
                                   class="btn btn-primary btn-sm">edit</a>
                                @endif
                            </td>

                        </tr>
                    @endforeach

                    </tbody>
                </table>
                <table class="table table-responsive table-striped">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Category Name</th>
                        <th>&nbsp;</th>

                        <th>
                            @if($isAdmin)
                                <a href="{{route('company_project_cat_edit',['company_key'=>$company->key])}}"
                               class="btn btn-success btn-sm">Add</a>
                            @endif
                        </th>

                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($company->projectsCategories as $category)
                        <tr>
                            <td>
                                <div style="background-color: {{$category->color}}"> &nbsp;</div>
                            </td>
                            <td>
                                <small>{{$category->name}}</small>
                            </td>
                            <th> </th>

                            <td>
                                @if($isAdmin)
                                <a
                                   href="{{route('company_project_cat_edit',['company_key'=>$company->key,'cid'=>CryptId::cryptIdToHash($category->id)])}}"
                                   class="btn btn-primary btn-sm">edit</a>
                                    @endif
                            </td>

                        </tr>
                    @endforeach

                    </tbody>
                </table>
                <table class="table table-responsive table-striped">
                    <thead>
                    <tr>

                        <th>Department Name</th>
                        <th></th>
                        <th>
                            @if($isAdmin)
                            <a href="{{route('company_department_create_or_update',['company_key'=>$company->key])}}"
                               class="btn btn-success btn-sm">Add</a></th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($company->departments as $department)
                        <tr>
                            <td>
                                <small>{{$department->name}}</small>
                            </td>

                            <td>
                                {{count($department->users)}}
                            </td>
                            <td>
                                @if($isAdmin)
                                <a
                                   href="{{route('company_department_create_or_update',['company_key'=>$company->key,'cid'=>CryptId::cryptIdToHash($department->id)])}}"
                                   class="btn btn-primary btn-sm">edit</a>
                                @endif
                            </td>

                        </tr>

                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>

    </div>


@stop
