<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function show() {
        $user = Auth::user();
        return view('profil.show', compact('user'));
    }

    public function edit() {
        $user = Auth::user();
        return view('profil.edit', compact('user'));
    }

    public function update(Request $request) {
        $user = Auth::user();
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|min:6|confirmed',
        ]);
        $user->nama = $request->nama;
        $user->email = $request->email;
        if($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();
        return redirect()->route('profil.show')->with('success', 'Profil berhasil diperbarui!');
    }
}