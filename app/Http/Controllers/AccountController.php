<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function viewChangePassword()
    {
        return view('change_password');
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'password_lama' => 'nullable|string',
            'password_baru' => 'nullable|string|min:8',
            'konfirm_password' => 'nullable|string|min:8|same:password_baru'
        ]);

        if ($validated['password_baru'] !== null) {
            if (!Hash::check($validated['password_lama'], $user->password)) {
                return redirect()->route('account.viewChangePassword')->with('error', 'Password lama tidak cocok.');
            }
        }

        DB::beginTransaction();

        try {
            if ($validated['password_baru'] !== null && $validated['konfirm_password'] !== null) {
                $user->update([
                    'password' => Hash::make($validated['password_baru'])
                ]);
            }

            DB::commit();

            return redirect()->route('account.viewChangePassword')->with('success', 'Password berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('account.viewChangePassword')->with('error', 'Gagal memperbarui password.');
        }
    }
}
