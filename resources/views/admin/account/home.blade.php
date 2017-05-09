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

                    </tr>

                    </thead>

                    @foreach($accounts as $account)
                        <tr>
                            <td>
                                {{$account->key_name}}
                            </td>

                            <td>
                                <a href="{{route('admin_account_edit',['id' => $account->id])}}">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>



@endsection
