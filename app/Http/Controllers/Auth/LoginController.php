<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('user.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            return redirect(route('product.index')); // Redirect to the intended page or home
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput();
    }
}
