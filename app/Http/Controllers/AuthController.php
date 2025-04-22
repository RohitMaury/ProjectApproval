<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => ($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Account created. Please login.');
    }

    public function showLogin() {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);
    
        $user = User::where('email', $request->email)->first();
    
        if ($user && $user->password === $request->password) {
            Auth::login($user); // manually log in the user
    
            $request->session()->regenerate();
    
            if ($user->role === 'admin') {
                return redirect('/admin/projects');
            }
    
            return redirect('/projects/create');
        }
    
        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }
    


    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
