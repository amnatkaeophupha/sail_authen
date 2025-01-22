<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.user-grid',compact('users'));
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'name'=> 'required',
            'email'=> 'required|email|unique:users',
            'mobile' =>'required|string|min:10|max:10',
            'password' =>'required|string|min:6',
            'role'=>'required|in:admin,manager',
        ]);

        if($request->active_users == 'on'){ $active = 1; }else{ $active = 0;}

        Cache::flush();

        $user = new User();
        $user->name = trim($request->name);
        $user->email = trim($request->email);
        $user->mobile = trim($request->mobile);
        $user->password = trim($request->password); //Hash::make(password) in model User;
        $user->role = trim($request->role);
        $user->active = $active;
        $rec = $user->save();

        event(new Registered($user));

        if ($rec) {

            return back()->with('success','You have Registered successfuly');

        }else{

            return back()->with('fail','You have Registered fail');
        }

    }

    public function update(Request $request)
    {
        $request->validate([
            'name'=> 'required',
            'email' => 'required|email',
            'mobile' =>'required|string|min:10|max:10',
            'role'=>'required|in:admin,manager'
        ]);

        $user = User::where('id',$request->id)->first();

        if($user->email === $request->email){

            $user = User::find($request->id);
            $user->name = trim($request->name);
            $user->mobile = trim($request->mobile);
            $user->role = trim($request->role);
            $user->save();

            return back()->with('success','You have Updated successfuly');

        }else{

            $request->validate(['email'=> 'required|email|unique:users,email',]);

            $user = User::find($request->id);
            $user->name = trim($request->name);
            $user->email = trim($request->email);
            $user->mobile = trim($request->mobile);
            $user->role = trim($request->role);
            $user->save();

            return back()->with('success','You have Updated successfuly');
        }
    }

    public function SendVerifyMail(Request $request)
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

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'active' => 'required|boolean', // Ensure `active` is either 0 or 1
        ]);

        $user = User::findOrFail($id);
        $user->active = $request->active;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'User status updated successfully!',
        ]);
    }

    public function destroy(string $id)
    {
        $user = User::where('id',$id)->first();

        if($user->avatar != null)
        {
            $path = 'avatars/'.$user->avatar;
            if (Storage::disk('public')->exists($path)) { Storage::disk('public')->delete($path);}
        }

        $user = User::findOrFail($id);
        $user->delete();
        return back()->with('success','You have Deleted successfuly');
    }
}
