<?php

namespace App\Http\Controllers;

use App\Mail\Websitemail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    public function login()
    {
        return view('login.login');
    }

    public function login_submit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
        if (Auth::attempt($credentials)) {
            if (Auth::user()->token != '') {
                Auth::guard()->logout();
                return redirect()->back()->with('error', 'User not found');
            } else {
                if(Auth::user()->role == 'Bimbingan Konseling'){
                    return redirect()->route('absen');
                }else{
                    return redirect()->route('user');
                }
            }
        } else {
            // Auth::guard()->logout();
            return redirect()->route('login')->with("error", "Email atau Password salah");
        }
    }

    public function logout()
    {
        Auth::guard()->logout();
        return redirect()->route('login');
    }

    public function forget()
    {
        return view('login.forget');
    }

    public function forget_submit(Request $request)
    {
        $email = User::where('email', $request->email)->first();
        if (!$email) {
            return redirect()->back()->with('success', 'User not found');
        }
        $token = hash('sha256', time());

        $email->token = $token;
        $email->update();

        $reset_link = url('reset-password/' . $token . '/' . $request->email);
        $subject = 'reset password';
        $message = 'klik link <a href="' . $reset_link . '">ini</a>';

        Mail::to($request->email)->send(new Websitemail($subject, $message));

        return redirect()->route('login');
    }

    public function reset($token, $email)
    {
        $reset = User::where('token', $token)->where('email', $email);
        if (!$reset) {
            return redirect()->route('login');
        }
        return view('login.reset', compact('token', 'email'));
    }

    public function reset_submit(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'new_password' => 'required|same:password'
        ]);

        $reset = User::where('token', $request->token)->where('email', $request->email)->first();
        $reset->password = Hash::make($request->password);
        $reset->token = '';
        $reset->update();

        return redirect()->route('login');
    }
}
