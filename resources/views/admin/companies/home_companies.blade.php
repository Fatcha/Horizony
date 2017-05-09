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
                            Account type
                        </th>
                        <th>

                        </th>

                    </tr>

                    </thead>
                    @foreach($companies as $company)
                        <tr>
                            <td>
                                {{$company->name}}
                            </td>
                            <td>
                                {{$company->accountType->key_name}}
                            </td>
                            <td>
                                <a href="{{route('admin_company_edit',['id' => $company->id])}}">Edit</a>
                            </td>

                        </tr>
                    @endforeach
                </table>
            </div>
        </div>

        </div>
    </div>



@endsection
