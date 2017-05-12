<?php

namespace App\Http\Controllers;

use App\Models\LinkedInProfile;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit() {

        $user = Auth::user();

        return view('user.edit', ['user' => $user]);
    }

    public function saveAccount(Request $request) {
        $this->validate($request,
            [
                'name' => 'required|max:150|min:2',
                 'email' => 'required|email',
                 'password' => 'confirmed|min:6|nullable',

            ]);
        $user = Auth::user();

        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if($request->input('password')){

            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect(route('user_account_edit', [

        ]));
    }

    public function registerOrLoginWithLinkedIn(Request $request) {

        $linkedinProfile = session('LinkedInProfile');

        $user = LinkedInProfile::findUseWithLinkedInId($linkedinProfile->id);
        if(!$user){

        }

        return redirect(route('user_account_edit', [

        ]));
    }

    public function socialConnect(Request $request) {
        $user = Auth::user();

        return view('user.social_connect', [
            'user' => $user
        ]);
    }
}
