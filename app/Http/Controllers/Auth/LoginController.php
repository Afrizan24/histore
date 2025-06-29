<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Transfer session favorites to database if any
            $this->transferSessionFavoritesToDatabase();

            if (Auth::user()->is_admin) {
                return redirect()->intended('/admin/dashboard');
            }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Transfer session favorites to database when user logs in
     */
    private function transferSessionFavoritesToDatabase()
    {
        $sessionFavorites = session('favorites', []);
        
        if (!empty($sessionFavorites) && auth()->check()) {
            $user = auth()->user();
            $transferredCount = 0;
            
            foreach ($sessionFavorites as $productId => $favoriteData) {
                // Check if favorite already exists in database
                if (!$user->favorites()->where('product_id', $productId)->exists()) {
                    $user->favorites()->create([
                        'product_id' => $productId
                    ]);
                    $transferredCount++;
                }
            }
            
            // Clear session favorites after transfer
            session()->forget('favorites');
            
            // Show notification if favorites were transferred
            if ($transferredCount > 0) {
                session()->flash('success', "Berhasil login! {$transferredCount} produk favorit telah disimpan ke akun Anda.");
            } else {
                session()->flash('success', 'Berhasil login!');
            }
        }
    }

    public function logout(Request $request)
    {
        // Check if user has session favorites before logout
        $sessionFavorites = session('favorites', []);
        $hasSessionFavorites = !empty($sessionFavorites);
        
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($hasSessionFavorites) {
            return redirect('/')->with('warning', 'Anda telah logout. Favorit yang disimpan sementara akan hilang. Login kembali untuk menyimpan favorit secara permanen.');
        }

        return redirect('/');
    }
} 