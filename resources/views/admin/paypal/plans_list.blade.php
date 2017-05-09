@extends('admin.layout')



@section('content')

    <div class="row">
        <div class="col-sm-5">
            {{Form::select('size', $statusArray, $currentStatus, ['onchange'=>'javascript:window.location="'.route('admin_paypal_list_plans',[]).'/"+this.value;'])}}
            <table class="table table-striped">
                <tbody>
                    <td>Paypal Id</td>
                    <td>Name</td>

                    <td>Description</td>
                    <td>State</td>
                    <td>Type</td>
                </tbody>

                @foreach($plans as $plan)

                    <tr>
                        <td>{{$plan->id}}</td>
                        <td>{{$plan->getName()}}</td>

                        <td>{{$plan->getDescription()}}</td>
                        <td>{{$plan->getState()}}</td>
                        <td>{{$plan->getType()}}</td>

                    </tr>
                @endforeach
            </table>
        </div>
    </div>

@endsection
