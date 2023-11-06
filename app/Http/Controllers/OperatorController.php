<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Operator;


class OperatorController extends Controller
{
    public function viewProfile()
    {
        $user = Auth::user();
        $operator = Operator::where('iduser', $user->id)->first();
        return view('operator.profile', ["operator" => $operator]);
    }

    public function viewEditProfile()
    {
        $user = Auth::user();
        $operator = Operator::where('iduser', $user->id)->first();

        return view('operator.edit_profile', ["operator" => $operator]);
    }

    public function update(Request $request)
    {
        try {
            $user = Auth::user();
            $operator = Operator::where('iduser', $user->id)->first();

            $validated = $request->validate([
                'nama' => 'required',
                'nip' => 'required',
                'tahun_masuk' => 'required',
                'alamat' => 'required',
                'no_telepon' => 'required',
                'username' => 'required',
                'foto' => 'nullable|image|max:10240',
            ]);
        
            if ($request->has('foto')) {
                $fotoPath = $request->file('foto')->store('profile', 'public');
                $validated['foto'] = $fotoPath;

                $user->update([
                    'foto' => $validated['foto'],
                ]);
            }
            
            $operator->nama = $request->nama;
            $operator->nip = $request->nip;
            $operator->tahun_masuk = $request->tahun_masuk;
            $operator->alamat = $request->alamat;
            $operator->no_telepon = $request->no_telepon;
            $operator->username = $request->username;
            
            $operator->save();

            $user->update([
                'username' => $request->username,
                'profile_completed' => 1
            ]);
            
            return redirect()->route('operator.viewProfile')->with('success', 'Data operator berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('operator.viewProfile')->with('error', 'Terjadi kesalahan saat memperbarui data operator.');
        }
    }

}

