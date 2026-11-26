<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Daftar akun resmi developer Kelompok 13 Kelas A/A2.
     */
    protected array $developerRoster = [
        1 => ['name' => 'Yanuar Dwi Prasetya', 'nim' => 'J0404251022', 'class' => 'Security & Auth Lead', 'badge' => 'badge_yanuar.png'],
        2 => ['name' => 'Arya Andra Diazka', 'nim' => 'J0404251155', 'class' => 'Lead Architect & DevOps', 'badge' => 'badge_arya.png'],
        3 => ['name' => 'Madina Dwiyana Putri', 'nim' => 'J0404251090', 'class' => 'DataTables & Export Lead', 'badge' => 'badge_madina.png'],
        4 => ['name' => 'Iasha Irdanti', 'nim' => 'J0404251115', 'class' => 'WYSIWYG & UI Lead', 'badge' => 'badge_iasha.png'],
    ];

    /**
     * Proses login standar trainer.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (in_array(strtolower(trim($credentials['email'])), ['developer@gmail.com', 'basic@gmail.com'], true)) {
            User::syncEvaluationAccounts();
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('pokedex.index'))->with('success', 'Selamat datang kembali, Trainer ' . Auth::user()->name . '!');
        }

        return back()->withErrors([
            'email' => 'Kombinasi email dan kata sandi tidak cocok.',
        ])->withInput($request->only('email'));
    }

    /**
     * Registrasi akun trainer publik baru (Role otomatis: 'trainer').
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'trainer',
            'trainer_class' => 'Pokemon Trainer',
            'avatar_badge' => 'badge_trainer.png',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('pokedex.index')->with('success', 'Akun Trainer berhasil didaftarkan! Selamat bertualang.');
    }

    /**
     * Logout sesi aktif.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('pokedex.index')->with('info', 'Sesi telah diakhiri. Sampai jumpa lagi, Trainer!');
    }

    /**
     * Quick-Switch Akun Developer / Trainer untuk kemudahan evaluasi & praktikum.
     */
    public function switchTrainer(Request $request, $id)
    {
        $id = (int) $id;

        if (isset($this->developerRoster[$id])) {
            $dev = $this->developerRoster[$id];
            $email = strtolower(str_replace(' ', '.', $dev['name'])) . '@apps.ipb.ac.id';

            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $dev['name'],
                    'password' => Hash::make('password123'),
                    'role' => 'developer',
                    'trainer_class' => $dev['class'],
                    'avatar_badge' => $dev['badge'],
                ]
            );

            // Pastikan role tetap developer
            if ($user->role !== 'developer') {
                $user->update(['role' => 'developer', 'trainer_class' => $dev['class']]);
            }

            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->route('pokedex.index')->with('success', "Beralih ke akun Developer: {$dev['name']} ({$dev['nim']})");
        }

        return redirect()->route('pokedex.index')->with('error', 'Profil tidak ditemukan.');
    }
}
