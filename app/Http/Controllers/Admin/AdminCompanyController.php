<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Country;
use App\Models\Quiz\QuizAnswer;
use App\Models\Quiz\QuizQuestion;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Quiz\Quiz;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AdminCompanyController extends Controller {

    public function __construct() {
        //   $this->middleware('guest', ['except' => 'logout']);
    }

    public function home(Request $request) {


        return view('admin.companies.home_companies', ['companies' => Company::get(),

        ]);
    }

    public function edit(Request $request, $id) {

        $company = Company::find($id);
        $countriesList = Country::getArrayCountriesName('en');

        if($request->isMethod('post')){
            $company->name = $request->input('name');
            $company->country_code = $request->input('country');
            $company->save();
        }



        return view('admin.companies.edit',
            [
                'company' => $company,
                'countriesList' => $countriesList,
                'users' => $company->users,

        ]);
    }


}
