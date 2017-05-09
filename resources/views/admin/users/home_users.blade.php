@extends('admin.layout')



@section('content')
    <div class="row">
        <div class="col-sm-5">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>
                            Name
                        </th>
                        <th>
                            email
                        </th>
                        <th>
                            Access level
                        </th>
                    </tr>

                    </thead>

                    @foreach($users as $user)
                        <tr>
                            <td>
                                {{$user->name}}
                            </td>
                            <td>
                                {{$user->email}}
                            </td>
                            <td>
                                <a href="{{route('admin_user_edit',['id' => $user->id])}}">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>



@endsection
