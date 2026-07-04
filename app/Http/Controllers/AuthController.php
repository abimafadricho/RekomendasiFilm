<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // =========================================================
    // HALAMAN LOGIN
    // =========================================================

    public function showLogin()
    {
        // Kalau sudah login, langsung redirect ke halaman utama
        if (session('user_id')) {
            return redirect()->route('home');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 6 karakter.',
        ]);

        // Cari user berdasarkan email
        $user = DB::table('users')->where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Email atau password salah.']);
        }

        // Simpan data user ke session
        session([
            'user_id'   => $user->id,
            'user_name' => $user->name,
            'user_email'=> $user->email,
            'user_role' => $user->role,
        ]);

        // Redirect berdasarkan role
        if ($user->role === 'admin') {
            return redirect()->route('admin.index')
                ->with('success', "Selamat datang, {$user->name}!");
        }

        return redirect()->route('home')
            ->with('success', "Selamat datang, {$user->name}!");
    }

    // =========================================================
    // HALAMAN REGISTER
    // =========================================================

    public function showRegister()
    {
        if (session('user_id')) {
            return redirect()->route('home');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|min:2|max:100',
            'email'    => 'required|email|max:150',
            'password' => 'required|min:6|confirmed',
        ], [
            'name.required'          => 'Nama wajib diisi.',
            'name.min'               => 'Nama minimal 2 karakter.',
            'email.required'         => 'Email wajib diisi.',
            'email.email'            => 'Format email tidak valid.',
            'password.required'      => 'Password wajib diisi.',
            'password.min'           => 'Password minimal 6 karakter.',
            'password.confirmed'     => 'Konfirmasi password tidak cocok.',
        ]);

        // Cek apakah email sudah terdaftar
        $existing = DB::table('users')->where('email', $request->email)->first();
        if ($existing) {
            return back()
                ->withInput($request->only('name', 'email'))
                ->withErrors(['email' => 'Email ini sudah terdaftar.']);
        }

        // Insert user baru
        $userId = DB::table('users')->insertGetId([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role'       => 'user',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Langsung login setelah register
        session([
            'user_id'   => $userId,
            'user_name' => $request->name,
            'user_email'=> $request->email,
            'user_role' => 'user',
        ]);

        return redirect()->route('home')
            ->with('success', "Akun berhasil dibuat. Selamat datang, {$request->name}!");
    }

    // =========================================================
    // LOGOUT
    // =========================================================

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('login')
            ->with('success', 'Anda berhasil logout.');
    }
}