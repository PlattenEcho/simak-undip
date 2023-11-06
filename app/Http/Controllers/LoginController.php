<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use ReCaptcha\ReCaptcha;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('login');
    }


    public function post(Request $request){
        $request->validate([
            'captcha'=>'required',
        ]);
    }
    public function authenticate(LoginRequest $request)
    {
        $recaptchaSecretKey = env('RECAPTCHA_SECRET_KEY');
        $recaptchaResponse = $request->input('g-recaptcha-response');
        
        $recaptcha = new ReCaptcha($recaptchaSecretKey);
        $recaptchaResult = $recaptcha->verify($recaptchaResponse, $_SERVER['REMOTE_ADDR']);

        if (!$recaptchaResult->isSuccess()) {
            return back()->with('loginError', 'Verifikasi bukan robot gagal');
        }

        
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('username', $credentials['username'])->first();

        if (!$user) {
            return back()->with('loginError', 'Username tidak ditemukan');
        }

        if (!Hash::check($credentials['password'], $user->password)) {
            return back()->with('loginError', 'Password salah');
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = $request->user(); 
        
            if ($user->idrole === 1) {
                return redirect()->intended('/operator/dashboard');
            } else if ($user->idrole === 2) {
                return redirect()->intended('/departemen/dashboard');
            } else if ($user->idrole === 3) {
                return redirect()->intended('/doswal/dashboard');
            } else if ($user->idrole === 4) {
                if ($user->profile_completed === 0) {
                    return redirect()->route('mahasiswa.viewEditProfile')->with('error', 'Harap lengkapi data diri terlebih dahulu.');
                }
                return redirect()->intended('/mahasiswa/dashboard');
            }
        }
        ;

        return back()->with('loginError', 'Login Gagal');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login')->with('logoutSuccess', 'Berhasil log out!');
    }
}
