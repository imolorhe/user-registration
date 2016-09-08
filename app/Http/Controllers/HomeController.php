<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if(Auth::user()->admin){
            $start_date = $request['start_date'];
            $end_date = $request['end_date'];
            
            $users = DB::table('users');
            if($start_date){
                $users = $users->where('created_at', '>=', Carbon::parse($start_date));
            }
            if($end_date){
                $users = $users->where('created_at', '<=', Carbon::parse($end_date));
            }
            
            $users = $users->paginate(5);
//            dd($users);
            return view('home', ['users' => $users, 'start_date' => $start_date, 'end_date' => $end_date]);
        }
        else{
            Session::reflash();
            return redirect()->route('editProfile', ['id' => Auth::user()->id]);
        }
    }
    
    public function editProfile($id){
        $user = User::findOrFail($id);
        if(!$this->validUser($user)){
            return redirect('/')->with('status', 'You are not authorised to perform that action.');
        }

        return view('edit', ['user' => $user]);
    }
    
    public function updateProfile(Request $request, $id){
        $user = User::findOrFail($id);

        $this->validate($request, [
          'name' => 'required|max:30|alpha_num',
          'email' => 'required|email|max:255|unique:users',
          'password' => 'required|min:6|confirmed',
          'first_name' => 'required|max:50',
          'last_name' => 'required|max:50',
          'phone_number' => 'required|min:7',
          'birthday' => 'required|date',
        ]);

        if(!$this->validUser($user)){
            return redirect('/')->with('status', 'You are not authorised to perform that action.');
        }
        $user->update([
          'name' => $request['name'],
          'email' => $request['email'],
          'password' => bcrypt($request['password']),
          'first_name' => $request['first_name'],
          'last_name' => $request['last_name'],
          'phone_number' => $request['phone_number'],
          'birthday' => $request['birthday'],
        ]);

        return redirect('/')->with('status', 'Profile information has been updated.');
    }

    public function deleteProfile($id){
        $user = User::findOrFail($id);

        if(!$this->validUser($user)){
            return redirect('/')->with('status', 'You are not authorised to perform that action.');
        }

        $user->delete();

        return redirect('/')->with('status', 'Profile has been deleted.');
    }

    public function createProfile(){
        if(!Auth::user()->admin){
            return redirect('/')->with('status', 'You are not authorised to perform that action.');
        }

        return view('create');
    }

    public function saveProfile(Request $request){

        $this->validate($request, [
          'name' => 'required|max:30|alpha_num',
          'email' => 'required|email|max:255|unique:users',
          'password' => 'required|min:6|confirmed',
          'first_name' => 'required|max:50',
          'last_name' => 'required|max:50',
          'phone_number' => 'required|min:7',
          'birthday' => 'required|date',
        ]);

        if(!Auth::user()->admin){
            return redirect('/')->with('status', 'You are not authorised to perform that action.');
        }

        $user = User::create([
          'name' => $request['name'],
          'email' => $request['email'],
          'password' => bcrypt($request['password']),
          'first_name' => $request['first_name'],
          'last_name' => $request['last_name'],
          'phone_number' => $request['phone_number'],
          'birthday' => $request['birthday'],
          'confirmation_code' => str_slug(str_random(20)),
        ]);

        $user->confirmed = true;
        $user->save();

        return redirect('/')->with('status', 'Profile has been created.');
    }

    public function validUser(User $user){
        return (Auth::user()->admin || Auth::user()->id == $user->id);
    }

}
