<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User as U;
use Illuminate\Support\Facades\Session;
use Log;
use Illuminate\Support\Facades\Auth;

class User extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Log::debug(Auth::user());
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);

        // auth
        if (Auth::attempt($credentials)) {
            $token = Auth::user()->createToken('myapp');

            return ['token' => $token->plainTextToken];
        }

        return response('error', 403);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response("logged out", 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        $user = U::where('email', '=', $request->email)->get();
        if ($user->first()) {
            if (Hash::check($request->password, $user->first()->password)) {
                Session::put('user', $request->email);
                return redirect('/event/');
            }
        }
        return back()->with(['error' => 'Email or password not correct']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        Session::pull('user');
        return redirect('organizer');
    }
}
