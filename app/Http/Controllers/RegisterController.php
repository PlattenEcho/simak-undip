<?php

namespace App\Http\Controllers;

use App\Models\User;
//use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function index()
    {
        return view("register");
    }

    public function store(Request $request)
    {
        $validatedData = request()->validate([
            "name" => "required|max:255",
            "email" => "required|email:dns|unique:users",
            "password" => "required|min:5|max:255",
        ]);

        User::create($validatedData);
        $request->session()->flash("success", "Registration Successfull");
        return redirect('/login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
