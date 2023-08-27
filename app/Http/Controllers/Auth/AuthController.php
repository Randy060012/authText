<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //
    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function textRegister(Request $request)
    {
        //dd($request->all());

        $messages = [
            "name.required" => "Your name is required",
            "name.max" => "Your name is too long",
            "email.required" => "Your email is required",
            "email.unique" => "Your email exist",
            "password.required" => "Your password is required",
            "password.same" => "Your password is differant",
        ];

        $validator = Validator::make($request->all(), [

            "name" => "bail|required|max:50|",
            "email" => "bail|required|email|unique:users,email",
            "password" => "bail|required|min:4|same:re_password",

        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->with('fail', $validator->errors()->first());
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        if ($user->save()) {
            return redirect()->route('loginText')->with('success', 'account created successfully');
        }
    }

    public function textLogin(Request $request)
    {
        // dd($request->all());
        $message = [
            "email.required" => "Votre email est requis",
            "email.exists" => "Votre email est invalide",
            "password.required" => "Le mot de passe est requis",
            "password.min" => "Le mot de passe est trop court",
        ];

        $validator = Validator::make($request->all(), [
            "email" => "bail|required|email|exists:users,email",
            "password" => "bail|required|min:8|max:50",
        ], $message);

        if ($validator->fails()) {
            // dd($validator->errors()->first());
            return redirect()->back()->with('fail', $validator->errors()->first());
        }
        $creds = $request->only('email', 'password');
        if (Auth::guard('web')->attempt($creds)) {
            return redirect()->route('index')->with('success', 'login');
        }
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('loginText')->with('message', 'Vous avez été déconnecté.');;
    }
}
