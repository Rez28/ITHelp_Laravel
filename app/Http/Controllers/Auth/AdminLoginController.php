<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RequestHelp;

class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.dashboard'); // pastikan kamu punya nama route admin.dashboard
        }

        return back()->withErrors([
            'email' => 'Login gagal. Cek kembali email dan password.',
        ]);
    }
    public function dashboard(Request $request)
    {
        $status = $request->query('status');
        $requests = RequestHelp::with('mapping')->when($status, fn($q) => $q->where('status', $status))->latest()->get();
        return view('admin.dashboard', compact('requests'));
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
