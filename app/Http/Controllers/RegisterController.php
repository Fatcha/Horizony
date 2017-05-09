<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AccountType;
use App\Models\Company;
use App\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Auth;
use Mail;


use Illuminate\Http\Request;
use \App\Models\Country;


class RegisterController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Welcome Controller
      |--------------------------------------------------------------------------
      |
      | This controller renders the "marketing page" for the application and
      | is configured to only allow guests. Like most of the other sample
      | controllers, you are free to modify or remove it as you desire.
      |
     */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        
    }
    public function form(Request $request){

        $countriesList = Country::getArrayCountriesName('en');

        return view('register.form',[
            'countriesList' => $countriesList
        ]);
    }

    public function save(Request $request){


        $this->validate($request, [
            'name' => 'required|unique:companies,name|max:100|min:2',
            'country' => 'required',

        ]);
        if(!Auth::check()){
            return "You have to be connected";
        }
        $user = Auth::user();

        $company  = new Company();
        $company->name = $request->input('name');
        $company->country_code = $request->input('country');
        $company->key = str_slug($request->input('name'), '-');
        $company->account_type = AccountType::ACCOUNT_FREE_KEY;
        $company->save();

        $company->users()->attach($user);

        return redirect(route('connected_dashboard'));;
    }
}
