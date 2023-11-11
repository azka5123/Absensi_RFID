<?php

namespace App\Http\Controllers;

use App\Mail\Websitemail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class SignupController extends Controller
{
    public function signup()
    {
        return view('signup.regis');
    }

    public function signup_submit(Request $request)
    {
        $token = hash('sha256', time());

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->hp = $request->hp;
        $user->password = Hash::make($request->password);
        $user->token = $token;
        $verif_link = url('signup/verification/' . $token . '/' . $request->email);
        $subject = 'verifikasi email';
        $message = 'klik link <a href="' . $verif_link . '">ini</a> untuk mengaktifkan akun anda';
        Mail::to($request->email)->send(new Websitemail($subject, $message));

        echo 'oke';
        $user->save();
    }

    public function signup_verification($token, $email)
    {
        $verif = User::where('token', $token)->where('email', $email)->first();
        $verif->token = NULL;
        $verif->update();
        return redirect()->route('login');
    }
}
