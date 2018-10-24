<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use http\Env\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['guest'])->except('logout');
    }

    protected function authenticated(\Illuminate\Http\Request $request, $user)
    {
        if ($user->isBlocked()) {
           $this->logout($request);
           return redirect('login')->withErrors(['error' =>'User was blocked!']);
       }
        $user->update(['date_of_last_sign_in' => Carbon::now()]);

        return redirect()->intended($this->redirectPath());
    }

}
