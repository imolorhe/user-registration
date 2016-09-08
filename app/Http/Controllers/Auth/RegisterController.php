<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
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
            'name' => 'required|max:30|alpha_num',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'phone_number' => 'required|min:7',
            'birthday' => 'required|date',
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
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'phone_number' => $data['phone_number'],
            'birthday' => $data['birthday'],
            'confirmation_code' => str_slug(str_random(20)),
        ]);

        $data['confirmation_code'] = $user->confirmation_code;

        Mail::send('emails.confirmation', $data, function($message) use ($data){
            $message->from('no-reply@sirmuel.com', 'Sir Muel');
            $message->subject('Please confirm your email');
            $message->to($data['email']);
        });

        return $user;
    }

    public function confirmEmail($confirmation_code){
        $user = User::where('confirmation_code', $confirmation_code)->first();

        if(count($user)){
            $user->confirmed = true;
            $user->save();

            return redirect('/login')->with('status', 'Your email has been confirmed. You can login now.');
        }
        return redirect('/login')->with('status', 'That was an invalid request.');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        if($this->create($request->all())){
            return redirect('/login')->with('status', 'Check your email and confirm your email address via the mail we sent to you in order to login.');
        }

        return redirect('/login')->with('status', 'Something went wrong. Please try again.');
    }
}
