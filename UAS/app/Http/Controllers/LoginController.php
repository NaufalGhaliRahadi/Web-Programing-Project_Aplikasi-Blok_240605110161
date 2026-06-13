<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Menampilkan halaman login
    public function index()
    {
        return view('login.index');
    }

    // Memproses login
    public function proses(Request $request)
    {
        $kredensial = [
            'user_name' => $request->user_name,
            'password'  => $request->password,
        ];

        if (Auth::attempt($kredensial)) {
            // Regenerasi session untuk keamanan (mencegah session fixation)
            $request->session()->regenerate();

            // Simpan waktu login ke session (format Indonesia)
            $request->session()->put('waktu_login', now()
                ->timezone('Asia/Jakarta')
                ->locale('id')
                ->isoFormat('dddd, D MMMM Y | HH:mm')
            );

            return redirect()->intended('/dashboard');
        }

        // Jika login gagal, kembali ke halaman login dengan pesan error
        return back()->withErrors(['gagal' => 'Username atau password salah']);
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}