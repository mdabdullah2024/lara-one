<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use Auth;
use App\Models\User;
use App\Mail\ForgotPasswordMail;
use Mail;
use Str;
class authController extends Controller
{
    public function login()
    {
       
        if (!empty(Auth::check())) {
            if (Auth::user()->user_type==1) {
                return redirect('/admin/dashboard');
            }else if (Auth::user()->user_type==2) {
                return redirect('/teacher/dashboard');
            }else if (Auth::user()->user_type==3) {
                return redirect('/student/dashboard');
            }else if (Auth::user()->user_type==4) {
                return redirect('/parent/dashboard');
            }
        }
        return view('backend.auth.login');
    }
    public function authLogin(Request $request)
    {
        $remember = !empty($request->remember) ? true : false;
        $email = $request->email;
        $password = $request->password;
        if(Auth::attempt(['email'=>$email,'password'=>$password],$remember)){
            if (Auth::user()->user_type==1) {
                return redirect('/admin/dashboard');
            }else if (Auth::user()->user_type==2) {
                return redirect('/teacher/dashboard');
            }else if (Auth::user()->user_type==3) {
                return redirect('/student/dashboard');
            }else if (Auth::user()->user_type==4) {
                return redirect('/parent/dashboard');
            }
        }else{
            return redirect()->back()->with('error','Please Enter Correct Email and Password.');
        }
    }
    public function authLogout()
    {
        Auth::logout();
        return redirect(url('/'));
    }

    public function forgotPassword()
    {
        return view('backend.auth.forgot');

    }

    public function ForgotPasswordPost(Request $request)
    {
        $user = User::getEmailSingle($request->email);
        if (!empty($user)) {
            $user->remember_token = Str::random(30);
            $user->save();
            Mail::to($user->email)->send(new ForgotPasswordMail($user));

            return redirect()->back()->with('success','Please check your email and reset your password.');

        }else{
            return redirect()->back()->with('error','Sorry ! Email Not Found in the Record.');
        }
    }

    public function reset($remember_token)
    {
        $user = User::getTokenSingle($remember_token);
        if (!empty($user)) {
            $data['user']=$user;
            return view('backend.auth.reset',$data);
        }else{
            abort(404);
        }
    }
    public function PostReset($token, Request $request)
    {
        if ($request->password == $request->cpassword) {
            $user = User::getTokenSingle($token);
            $user->password = Hash::make($request->password);
            $user->remember_token = Str::random(30);
            $user->save();
            return redirect()->route('auth.login')->with('success','Password successfully reset.');
        }else{
            return redirect()->back()->with('error','Password and Confirm Password does not match');
        }
    }

    
    
}
