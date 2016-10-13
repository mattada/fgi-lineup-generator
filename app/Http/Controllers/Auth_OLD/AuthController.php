<?php

namespace App\Http\Controllers\Auth;

use App\Plan;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

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

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        # Validate
        if ($validator->fails()) {

            return $this->callback(function() use ($request, $validator){

                $this->throwValidationException(
                    $request, $validator
                );

            }, function() use ($validator){

                return $this->returnErrorArray($validator->getMessageBag()->first());

            }, $request);
        }

        # Login User
        Auth::guard($this->getGuard())->login($this->create($request->all()));

        # Return
        return $this->callback(function(){

            return redirect($this->redirectPath());

        }, function(){

            return $this->returnSuccessArray( Auth::user()->toArray() );

        }, $request);
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $lockedOut = $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->getCredentials($request);

        if (Auth::guard($this->getGuard())->attempt($credentials, $request->has('remember'))) {
            return $this->handleUserWasAuthenticated($request, $throttles);
        } else{

            $this->register($request);

            return $this->handleUserWasAuthenticated($request, $throttles);
        }


        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
//        if ($throttles && ! $lockedOut) {
//            $this->incrementLoginAttempts($request);
//        }
//
//        return $this->sendFailedLoginResponse($request);
    }

    protected function handleUserWasAuthenticated(Request $request, $throttles)
    {
        if ($throttles) {
            $this->clearLoginAttempts($request);
        }

        if (method_exists($this, 'authenticated')) {
            return $this->authenticated($request, Auth::guard($this->getGuard())->user());
        }

        return $this->callback(function(){

            return redirect($this->redirectPath());

        }, function(){

            return $this->returnSuccessArray( Auth::user()->toArray() );

        }, $request);
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
            'email' => 'required|email|max:255|unique:users',
            'token' => 'required|min:6',
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
//        $cointent = App::make('Cointent');
//
//        $cointentResult = $cointent->createUser($data['email']);
//
//        if ($cointentResult->status == 'success') {
//
//            if (property_exists($cointentResult, 'createdUser')) {
//
//                $data['cointent_id'] = $cointentResult->createdUser->userId;
//                $data['cointent_passCode'] = $cointentResult->createdUser->passwordSetupCode;
//
//            }
//
//            if (property_exists($cointentResult, 'queriedUser')) {
//
//                $data['cointent_id'] = $cointentResult->queriedUser->userId;
//                $data['cointent_passCode'] = $cointentResult->queriedUser->passwordSetupCode;
//            }
//
//        }

        $user = User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['email']),
            'cointent_id' => $data['uid'],
            'cointent_client_id' => $data['clientId']
        ]);

        return $user;
    }
}
