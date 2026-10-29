<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Show admin login form.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    /**
     * Handle admin login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $remember = $request->boolean('remember');

        try {
            if (Auth::attempt($credentials, $remember)) {
                $request->session()->regenerate();

                return redirect()->intended(route('admin.dashboard'))
                    ->with('success', 'Selamat datang kembali, ' . Auth::user()->name . '!');
            }
        } catch (\Illuminate\Database\QueryException $e) {
            $msg = $e->getMessage();
            if (str_contains($msg, '127.0.0.1') || str_contains($msg, 'Connection refused')) {
                throw ValidationException::withMessages([
                    'email' => 'Database Neon belum tersambung ke project ini di Vercel. Buka Vercel > Storage > akebono-db > Connect Project, lalu Redeploy.',
                ]);
            }
            if (str_contains($msg, 'users') && (str_contains($msg, 'does not exist') || str_contains($msg, 'relation'))) {
                throw ValidationException::withMessages([
                    'email' => 'Tabel database belum dibuat. Silakan buka /admin/setup-db untuk membuat tabel dan akun admin secara otomatis.',
                ]);
            }
            throw ValidationException::withMessages([
                'email' => 'Gagal terhubung ke database: ' . $e->getMessage(),
            ]);
        } catch (\PDOException $e) {
            throw ValidationException::withMessages([
                'email' => 'Koneksi database gagal (' . $e->getMessage() . '). Pastikan database Neon sudah dihubungkan ke project Vercel.',
            ]);
        }

        throw ValidationException::withMessages([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ]);
    }

    /**
     * Handle logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('guide.index')
            ->with('success', 'Anda telah berhasil keluar (logout).');
    }
}

