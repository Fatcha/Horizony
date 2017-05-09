<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountType;
use App\Models\Country;
use App\Models\Quiz\QuizAnswer;
use App\Models\Quiz\QuizQuestion;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Quiz\Quiz;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AdminAccountController extends Controller {

    public function __construct() {
        //   $this->middleware('guest', ['except' => 'logout']);
    }

    public function home(Request $request) {

        $accounts = AccountType::get();

        return view('admin.account.home', ['accounts' => $accounts

        ]);
    }

    public function edit(Request $request, $id) {

        $account = AccountType::find($id);
        $countriesList = Country::getArrayCountriesName('en');

        if($request->isMethod('post')){

            $account->users_limit           = $request->input('users_limit');
            $account->real_price            = $request->input('real_price');
            $account->max_tests_in_progress = $request->input('max_tests_in_progress');

            $account->save();

            return redirect(route('admin_account_edit',['id' => $account->id]));
        }



        return view('admin.account.edit',
            [
                'account' => $account,


            ]);
    }


}
