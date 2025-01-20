<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('admin.user-grid',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
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

            return back()->with('success','You have Registered successfuly');

        }else{

            return back()->with('fail','You have Registered fail');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        echo $id;
        $user = User::findOrFail($id);
        $user->delete();
        return back()->with('success','You have Deleted successfuly');
    }
}
