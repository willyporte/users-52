<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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

    protected $username = 'email'; // or 'nickname';
    protected $maxLoginAttempts = 3;
    protected $lockoutTime = 60; // seconds

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['getLogout','getConfirmation','newEmail']]);
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
            //'nickname' => 'required|max:20|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
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
        /*
         * Modificada mas abajo para evitar que el usuario
         * nos modifique el role (lo fuerzo a 'user')
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        */

        $user = new User([
            'name' => $data['name'],
            //'nickname' => $data['nickname'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);
        $user->role = 'user';
        $user->registration_token = str_random(40);
        $user->remember_token = str_random(10);
        $user->save();

        $url = route('confirmation', ['token' => $user->registration_token]);
        // email to user sent
        Mail::send('auth.emails.registration',compact('user','url'), function($m) use ($user){
            $m->to($user->email, $user->name)->subject('Attiva la tua Account!');
        });
        return $user;

    }

    /**
     * Get the path to the login route.
     *
     * @return string
     */
    public function loginPath()
    {
        // return property_exists($this, 'loginPath') ? $this->loginPath : '/login';
        return route('login');
    }

    public function redirectPath()
    {
        /*
        if (property_exists($this, 'redirectPath')) {
            return $this->redirectPath;
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/';
        */

        return route('home');
    }

    /**
     * Get the failed login message.
     *
     * @return string
     */

    /*
     * No es necesario: cambiar/agregar en es/auth.php
     * 'failed' => 'Estas credenciales no coinciden con nuestros registros',
     */

    /*
     * se podria simplificar y hacerlo mas portable:
     * return trans('validation.login');
     */
    /*
    protected function getFailedLoginMessage()
    {
        return Lang::has('auth.failed')
            ? Lang::get('auth.failed')
            : 'These credentials do not match our records.';
    }
    */

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function getCredentials(Request $request)
    {
        return [
            //'nickname' => $request->get('nickname'),
            'email' => $request->get('email'),
            'password' => $request->get('password'),
            //'registration_token' => null,
            /*
             * permito accesso limitado a los "no verificados" y con el middleware IsVerified
             * limito las areas de acceso
             */
            'active' => true
        ];
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postRegister(Request $request)
    {

        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        //Auth::login($this->create($request->all()));

        $user = $this->create($request->all());
        //return redirect($this->redirectPath());
        return redirect()->route('login')->with('alert','Per favore conferma la tua Email: '.$user->email);

    }

    public function getConfirmation($token)
    {

        $user = User::where('registration_token', $token)->firstOrFail();
        $user->registration_token = null;
        $user->save();

        if(auth()->user()) {
            // en el caso que conferma el email con una sesion abierta lo mando al home
            return redirect()->route('home')->with('alert', 'E-mail confermato! Buon divertimento.');
        }
        else {
            // si conferma el email y no ha iniciado sesion lo mando al login
            return redirect()->route('login')->with('alert', 'E-mail confermato ora puoi iniziare sessione');
        }
    }

    public function newEmail() {

        $user = auth()->user();

        if($user->registration_token != null) {
            $url = route('confirmation', ['token' => $user->registration_token]);
            // email to user sent
            Mail::send('auth.emails.registration', compact('user', 'url'), function ($m) use ($user) {
                $m->to($user->email, $user->name)->subject('Attiva la tua Account!');
            });
            return redirect()->route('home')
                ->with('alert','Ti abbiamo inviato un nuovo email. Per favore conferma la tua Email: '.$user->email.' Guarda pure tra gli spam!');
        }
        else {
            return redirect()->route('home')
                ->with('alert', 'Ooopsss il tuo email è già verificato!');
        }
    }

}
