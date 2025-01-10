<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;



class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('auth.signin');
    }

    public function store(Request $request)
    {

        //dd($request->all());
        $request->validate([
            'name'=> 'required',
            'email'=> 'required|email|unique:users',
            'password' =>'required|string|min:6',
            'role'=>'required|in:admin,user'
        ]);

        $user = new User();
        $user->name = trim($request->name);
        $user->email = trim($request->email);
        $user->password = trim($request->password); //Hash::make(password) in model User;
        $user->role = trim($request->role);
        //$user->remember_token = Str::random(50);
        $rec = $user->save();

        if ($rec) {

            return redirect('signin')->with('success','You have Registered successfuly');

        }else{

            return back()->with('fail','You have Registered fail');
        }
    }

    public function login(Request $request)
    {
        $request->validate(['email'=> 'required|email','password' =>'required']);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember'); // Check if "remember" is checked

        $user = User::where('email', $credentials['email'])->first();
        if (!$user){ return back()->with('fail', 'The email does not exist in our records.'); }
        if (!Hash::check($credentials['password'], $user->password)){ return back()->with('fail', 'The provided password is incorrect.'); }
        //if($user->activate==null){ return back()->with('fail', 'User is not Active.'); }


        if (Auth::attempt($credentials,$remember, true))
        {
            if(Auth::user()->role=='admin'){

                return redirect()->intended('/admin');
                //return view('admin.dashboard');

            }elseif(Auth::user()->role=='user'){

                return redirect()->intended('/user');
                //return view('user.dashboard');

            }else{

                Auth::logout();
                $request->session()->invalidate();
            }
        }
    }

    public function sendResetLinkEmail(Request $request)
    {
        // Validate the email input
        $request->validate(['email' => 'required|email|exists:users,email',]);

        // Send the reset link
        $status = Password::sendResetLink($request->only('email'));

        // Check the status and return a response
        return $status === Password::RESET_LINK_SENT
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);

    }

    public function resetPassword(Request $request)
    {
       // dd($request->all());
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
        ? redirect('signin')->with('success', __($status))
        : back()->withErrors(['email' => [__($status)]]);

    }

    public function forgot_password_post(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);
        $token = Str::random(64);

        //DB::table('password_reset_tokens')->insert(['email'=>$request->email, 'token'=>$token, 'created_at'=>Carbon::now()]);

        $user = User::where('email', $request['email'])->first();
        $user->remember_token = Str::random(64);
        $user->save();

       // Mail::to($user->email)->send(new ForgotPasswordMail($user));

    }


    public function signout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('signin');
    }
}

