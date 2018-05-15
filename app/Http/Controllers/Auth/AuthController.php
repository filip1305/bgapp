<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Auth;
use Mail;
use Input;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $redirectPath = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6|regex:/^[a-zA-Z0-9`~!@#$%^&*-_=+]+$/',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $token = User::getToken();

        Mail::send('emails.register', ['data' => $data, 'token' => $token], function ($m) use ($data) {
            $m->to($data['email'], $data['name'])->subject('Confirm your account');
        });

        $user = new User();
        $user->name = $data['name'];
        $user->email = strtolower($data['email']);
        $user->password = bcrypt($data['password']);
        $user->activation_code = $token;
        $user->save();

        return $user;
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function postLogin(Request $request)
    {
        $email = strtolower($request->email);

        // Verify if user account is activated
        $userActive = $this->verifyUserActivated($email);

        if ($userActive === null) {
            return redirect('auth/login')->with('error_msg','Your account is not found in database. Please, register');
        }

        if (!$userActive) {
            return redirect('auth/login')->with('error_msg','Your account is not activated. Please, check your email');
        }

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        $credentials = array("email" => $email, "password" => $request->password);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            return $this->handleUserWasAuthenticated($request, $throttles);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles) {
            $this->incrementLoginAttempts($request);
        }

        return redirect('auth/login')->with('error_msg','These credentials do not match our records');
    }

    /**
     * Verify if user account is activated or not
     * If account is not activated resend a verification email
     *
     * @param string $email
     * @return mixed
     */
    private function verifyUserActivated($email)
    {
        if (is_null($email)) {
            $email = strtolower(Input::get('email'));
        }

        // Verify if the user isnt actived yet to resend email verification
        $user = User::where('email', 'like', $email)->select('active','activation_code','name', 'email')->first();

        if (is_null($user)) {
            return null;
        }

        if ($user->active == 0) {
            Mail::send('emails.register', ['data' => $user, 'token' => $user->activation_code], function ($m) use ($user) {
                $m->to($user->email, $user->name)->subject('Confirm your account');
            });

            return false;
        }

        return true;
    }

    public function postRegister(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $this->create($request->all());

        return redirect('auth/login');
    }

    public function activateAccount($code) {
        if(!$code) {
            return redirect('auth/login')->with('error_msg','Activation code is invalid');
        }

        $user = User::where('activation_code', $code)->first();

        if (!$user) {
            return redirect('auth/login')->with('error_msg','Activation code is invalid');
        }

        $user->active = 1;
        $user->activation_code = null;
        $user->save();

        Auth::login($user);

        return redirect('boardgames/')->with('success','You successfully activated your account');
    }

    public function getForgotPass() {
        return view('auth.forgort', array());
    }

    public function postForgotPass() {
        
        $email = strtolower(Input::get('email'));

        $user = User::where('email', $email)->first();

        if (is_null($user)) {
            return redirect('auth/login')->with('error_msg','Email not found in our database');
        }

        $token = $user->getResetPasswordCode();

        Mail::send('emails.recovery', ['data' => $user, 'token' => $token], function ($m) use ($user) {
            $m->to($user->email, $user->name)->subject('Account recovery');
        });

        return redirect('auth/login')->with('success','Please check your email for a message with reset password link');
    }

    public function getResetPass($code) {
        $user = User::where('reset_password_code', $code)->first();

        if (!$user) {
            return redirect('auth/login')->with('error_msg','Reset password code is invalid');
        }

        if ($user->active == 0) {
            $user->active = 1;
            $user->activation_code = null;
            $user->save();
        }
        
        return view('auth.reset', array(
            "code" => $code
        ));
    }

    public function postResetPass() {
        $code = Input::get('code');

        if ((Input::get('password') === Input::get('password_confirmation')) && (strlen(Input::get('password')) > 0)) {
            $user = User::where('reset_password_code', $code)->first();

            $user->reset_password_code = null;
            $user->password = bcrypt(Input::get('password'));
            $user->save();

            Auth::login($user);

            return redirect('boardgames/')->with('success','Password reset was successful');
        } else {
            return redirect('auth/recover/'.$code)->with('error_msg','Password don\'t match');
        }
    }
}
