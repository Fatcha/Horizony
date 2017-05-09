<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Quiz\QuizAnswer;
use App\Models\Quiz\QuizQuestion;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Quiz\Quiz;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AdminUserController extends Controller
{

    public function __construct()
    {
        //   $this->middleware('guest', ['except' => 'logout']);
    }

    public function home(Request $request, $quizId = null)
    {



        return view('admin.users.home_users', [
            'users' => User::get(),

        ]);
    }

    public function edit(Request $request, $id) {

        $user = User::find($id);
        $countriesList = Country::getArrayCountriesName('en');

        if($request->isMethod('post')){
            $user->name = $request->input('name');
            $user->email = $request->input('email');

            $user->save();

            return redirect(route('admin_user_edit',['id'=>$user->id]));
        }



        return view('admin.users.edit',
            [
                'user' => $user,
                'countriesList' => $countriesList,


            ]);
    }



}
