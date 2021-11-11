<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display login page for user.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('layouts.auth.login');
    }



    /**
     * Log the user in the application.
     *
     * @param  LoginRequest $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(LoginRequest $request)
    {
        $credentials = ['email' => $request->email, 'password' => $request->password, 'status' => 1];
        $remember = $request->get('remember_me') == true ? true : false;
        if (Auth::attempt($credentials, $remember)) {
            return redirect()->intended('dashboard');
        }
        
        return back()->withInput()->with('message', 'Login Failed');
    }


    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
