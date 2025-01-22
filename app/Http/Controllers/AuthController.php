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
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Auth\Events\Registered;

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
            'mobile' =>'required|string|min:10|max:10',
            'password' =>'required|string|min:6',
            'role'=>'required|in:admin,manager'
        ]);

        $user = new User();
        $user->name = trim($request->name);
        $user->email = trim($request->email);
        $user->mobile = trim($request->mobile);
        $user->password = trim($request->password); //Hash::make(password) in model User;
        $user->role = trim($request->role);
        //$user->remember_token = Str::random(50);
        $rec = $user->save();

        if ($rec) {

            event(new Registered($user));
            //return redirect('signin')->with('success','You have Registered successfuly');
            return redirect('signin')->with('success','Verify Your Email Address');

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

                return redirect()->intended('admin');
                //return view('admin.dashboard');

            }elseif(Auth::user()->role=='manager'){

                //echo Auth::user()->role;
                return redirect()->intended('manager');
                //return view('manager.dashboard');

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

    public function profile_images(Request $request)
    {
        $request->validate(['avatars' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',]);
        $user = DB::table('users')->where('id', Auth::user()->id)->first();

        if($user->avatar != null)
        {
            $path = 'avatars/'.$user->avatar;
            if (Storage::disk('public')->exists($path)) { Storage::disk('public')->delete($path);}
            User::where('id', Auth::user()->id)->update(['avatar' => null]);
        }

        $avatar = $request->file('avatars');
        $avatar_name = 'userid-'.$user->id.'.'.$request->avatars->extension();
        $avatar_path = $avatar->storeAs('avatars', $avatar_name, 'public'); // Upload to storage/app/public/avatars
        //dd($avatar_path);
        $manager = new ImageManager(new Driver());
        $image = $manager->read(Storage::disk('public')->get($avatar_path));
        $image->cover(100,100,'center');
        $image->save(Storage::disk('public')->path($avatar_path));
        User::where('id', Auth::user()->id)->update(['avatar' => $avatar_name]);
        return back()->with('success', 'Profile image uploaded successfully.');
    }

    public function profile_update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required|string|min:10|max:10',
            'role'=>'required|in:admin,manager'
        ]);

        $user = User::where('id', Auth::user()->id)->first();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->save();
        return back()->with('data_success', 'Profile updated successfully.');
    }

    public function resize(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();

        $path = $user->avatar;

        if (!Storage::disk('public')->exists($path)) {
            abort(404, 'Image not found.');
        }

        $manager = new ImageManager(new Driver());

        $image = $manager->read(Storage::disk('public')->get($path));

        $image->scale(100);

        $image->save(Storage::disk('public')->path($path));
    }

    public function signout(Request $request)
    {

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('signin');
    }

    public function destroy(Request $request)
    {
        echo "recommended to delete the user account";
        // if(Auth::user()->avatar != null)
        // {
        //     $path = 'avatars/'.Auth::user()->avatar;
        //     if (Storage::disk('public')->exists($path)) { Storage::disk('public')->delete($path);}
        // }
        // $user = Auth::findOrFail(Auth::user()->id);
        // $user->delete();

        // Auth::logout();
        // $request->session()->invalidate();
        // $request->session()->regenerateToken();
        // return redirect('signin');
    }
}

