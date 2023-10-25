<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class AccountController extends Controller
{
    public function generateAccount(Request $request)
    {
        // Ambil NIM dari request
        $nim = $request->input('nim');

        // Ambil email dari request (diasumsikan input email pada formulir memiliki atribut "name" email)
        $email = $request->input('email');

        // Generate password acak
        $password = Str::random(10); // Menghasilkan password acak 10 karakter

        // Simpan akun pengguna dengan email dan password yang sesuai
        $user = new User();
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->role = 'mahasiswa';

        $user->save();

        // Data akun yang baru dibuat
        $username = $user->email;

        // Tampilkan informasi akun dalam modal popup
        return view('popup')->with('username', $username)->with('password', $password);
    }

}
