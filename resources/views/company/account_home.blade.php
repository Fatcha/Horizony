@extends('layouts.app')


@section('content')
    <div class="container">


        <div class="row">

            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Account company
                    </div>
                    <div class="panel-body">
                        Current account:
                        <span class="label label-success pull-right">
                            {{$company->getCurrentAccount()->key_name}}
                        </span>
                        <br>
                        @if($company->getCurrentAccount()->key_name !== \App\Models\AccountType::ACCOUNT_FREE_KEY)
                            End date :  <span class="label label-info pull-right">{{\Carbon\Carbon::parse( $company->getCurrentBuying()->end_date)->format('d M  Y')}}</span>

                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($accountsType as $account)
                <div class="col-md-3">
                    <div class="thumbnail">
                        <div class="caption">
                            <div>
                                {{$account->key_name}}
                            </div>

                            <ul class="list-group">
                                <li class="list-group-item">
                                    Simultaneous pending tests:

                                    <span class="label label-success ">
                                         {{$account->max_tests_in_progress == \App\Models\AccountType::ACCOUNT_NUMBER_NO_LIMIT ? \App\Models\Company::PENDING_TEST_CONCURRENT_UNLIMITED : $account->max_tests_in_progress }}
                                    </span>
                                </li>
                                <li class="list-group-item">
                                    Number of users:
                                    <span class="label label-success pull-right">
                                    {{$account->users_limit == \App\Models\AccountType::ACCOUNT_NUMBER_NO_LIMIT ? \App\Models\Company::PENDING_TEST_CONCURRENT_UNLIMITED : $account->users_limit }}
                                    </span>
                                </li>

                                <li class="list-group-item">
                                    Price : <span class="label label-success pull-right">{{$account->real_price}} €</span>
                                </li>
                            </ul>
                            <div class="text-center">

                                <a href="{{route('company_account_do_change',['company_key' =>$company_key , 'accountKey' => $account->key_name])}}"
                                   class="btn btn-primary btn-lg btn-block">
                                    Choose
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@stop
