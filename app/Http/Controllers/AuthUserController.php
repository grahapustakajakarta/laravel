<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Notifications\VerifyUserEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Laravel\Socialite\Facades\Socialite;

class AuthUserController extends Controller
{
    /* ----------------------------------------------------------------
     |  Halaman Sign In
     | ---------------------------------------------------------------- */
    public function showSignIn()
    {
        if (Auth::guard('pengguna')->check()) {
            return redirect()->route('home');
        }
        return view('pages.auth.signin');
    }

    /* ----------------------------------------------------------------
     |  Halaman Sign Up (Daftar Gratis)
     | ---------------------------------------------------------------- */
    public function showSignUp()
    {
        if (Auth::guard('pengguna')->check()) {
            return redirect()->route('home');
        }
        return view('pages.auth.signup');
    }

    public function signUp(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:pengguna,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $pengguna = Pengguna::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'user',
        ]);

        // Send email verification
        self::sendVerificationNotification($pengguna);

        Auth::guard('pengguna')->login($pengguna);

        return redirect()->route('user.verification.notice')->with('info', 'Pendaftaran berhasil! Silakan verifikasi email Anda.');
    }

    /* ----------------------------------------------------------------
     |  Proses Sign In
     | ---------------------------------------------------------------- */
    public function signIn(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        $pengguna = Pengguna::where('email', $request->email)->first();

        if ($pengguna && Hash::check($request->password, $pengguna->password)) {
            Auth::guard('pengguna')->login($pengguna, $request->boolean('remember'));

            // Jika email belum diverifikasi → redirect ke halaman notice
            if (!$pengguna->hasVerifiedEmail()) {
                return redirect()->route('user.verification.notice')
                    ->with('info', 'Silakan verifikasi email Anda terlebih dahulu.');
            }

            return redirect()->intended(route('home'))
                ->with('success', 'Selamat datang, ' . $pengguna->nama . '!');
        }

        return back()
            ->withErrors(['email' => 'Email atau password salah.'])
            ->withInput($request->only('email'));
    }

    /* ----------------------------------------------------------------
     |  Logout
     | ---------------------------------------------------------------- */
    public function signOut(Request $request)
    {
        Auth::guard('pengguna')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'Anda telah keluar.');
    }

    /* ----------------------------------------------------------------
     |  Halaman verifikasi email (notice)
     | ---------------------------------------------------------------- */
    public function verificationNotice()
    {
        $pengguna = Auth::guard('pengguna')->user();

        if ($pengguna && $pengguna->hasVerifiedEmail()) {
            return redirect()->route('home');
        }

        return view('pages.auth.verify');
    }

    /* ----------------------------------------------------------------
     |  Proses verifikasi email (klik link dari email)
     | ---------------------------------------------------------------- */
    public function verifyEmail(Request $request, $id, $hash)
    {
        $pengguna = Pengguna::findOrFail($id);

        // Cek hash
        if (!hash_equals(sha1($pengguna->email), $hash)) {
            abort(403, 'Link verifikasi tidak valid.');
        }

        // Cek tanda tangan URL
        if (!$request->hasValidSignature()) {
            return redirect()->route('user.verification.notice')
                ->withErrors(['verify' => 'Link verifikasi telah kadaluarsa. Silakan kirim ulang.']);
        }

        if (!$pengguna->hasVerifiedEmail()) {
            $pengguna->markEmailAsVerified();
        }

        // Auto-login jika belum login
        if (!Auth::guard('pengguna')->check()) {
            Auth::guard('pengguna')->login($pengguna);
        }

        return redirect()->route('home')
            ->with('success', 'Email berhasil diverifikasi! Selamat datang, ' . $pengguna->nama . '.');
    }

    /* ----------------------------------------------------------------
     |  Kirim ulang email verifikasi
     | ---------------------------------------------------------------- */
    public function resendVerification(Request $request)
    {
        $pengguna = Auth::guard('pengguna')->user();

        if (!$pengguna) {
            return redirect()->route('user.signin');
        }

        if ($pengguna->hasVerifiedEmail()) {
            return redirect()->route('home');
        }

        $this->sendVerificationNotification($pengguna);

        return back()->with('success', 'Email verifikasi telah dikirim ulang. Cek inbox Anda.');
    }

    /* ----------------------------------------------------------------
     |  Helper: Kirim notifikasi verifikasi
     | ---------------------------------------------------------------- */
    public static function sendVerificationNotification(Pengguna $pengguna): void
    {
        $url = URL::temporarySignedRoute(
            'user.verification.verify',
            now()->addMinutes(60),
            ['id' => $pengguna->id, 'hash' => sha1($pengguna->email)]
        );

        $pengguna->notify(new VerifyUserEmail($url));
    }

    /* ----------------------------------------------------------------
     |  Socialite Logic
     | ---------------------------------------------------------------- */
    public function redirectToProvider($provider)
    {
        $allowedProviders = ['google', 'twitter'];
        if (!in_array($provider, $allowedProviders)) {
            abort(404);
        }

        try {
            return Socialite::driver($provider)->redirect();
        } catch (\Exception $e) {
            return redirect()->route('user.signin')->with('error', 'Konfigurasi login ' . ucfirst($provider) . ' belum diatur (Kunci API tidak ditemukan).');
        }
    }

    public function handleProviderCallback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Socialite callback error ({$provider}): " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine());
            return redirect()->route('user.signin')->with('error', 'Gagal login melalui ' . ucfirst($provider) . '. Pesan: ' . $e->getMessage());
        }

        $email = $socialUser->getEmail() ?? $socialUser->getId() . '@' . $provider . '.com';

        // Cari berdasarkan email atau provider_id
        $user = Pengguna::where('email', $email)
                        ->orWhere(function($query) use ($provider, $socialUser) {
                            $query->where('provider_name', $provider)
                                  ->where('provider_id', $socialUser->getId());
                        })->first();

        if (!$user) {
            // Jika belum ada, daftar otomatis
            $user = Pengguna::create([
                'nama' => $socialUser->getName() ?? $socialUser->getNickname() ?? 'User',
                'email' => $email,
                'password' => null,
                'role' => 'user',
                'provider_name' => $provider,
                'provider_id' => $socialUser->getId(),
                'provider_token' => $socialUser->token,
                'email_verified_at' => now(), // Otomatis terverifikasi
            ]);
        } else {
            // Update token atau info login jika sudah ada
            $user->update([
                'provider_name' => $provider,
                'provider_id' => $socialUser->getId(),
                'provider_token' => $socialUser->token,
            ]);
            if (!$user->email_verified_at) {
                $user->update(['email_verified_at' => now()]);
            }
        }

        Auth::guard('pengguna')->login($user);

        return redirect()->intended(route('home'))->with('success', 'Berhasil login melalui ' . ucfirst($provider) . '.');
    }
}
