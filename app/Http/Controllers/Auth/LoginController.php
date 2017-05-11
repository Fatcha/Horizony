<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function connectWithCryptedId($sha_id, $sha1_crypted_id) {

        $user = User::whereRaw('sha1(id) = ?', $sha_id)
            ->whereRaw('sha1(crypted_id) = ?', $sha1_crypted_id)
            ->first();

        Auth::login($user);

        return redirect(route('user_account_social_connect'));
        // return redirect(route('connected_dashboard'));

    }
}
