<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Services\SupabaseAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function __construct(
        private SupabaseAuthService $supabaseAuth
    ) {}

    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $email = $request->string('email')->toString();
        $password = $request->string('password')->toString();

        $admin = $this->authenticate($email, $password);

        if (! $admin) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials do not match our records.'],
            ]);
        }

        Auth::guard('admin')->login($admin, false);
        $request->session()->regenerate();
        $request->session()->put('admin_login_time', time());
        $request->session()->put('admin_last_activity', time());

        return redirect()->intended(route('admin.dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    private function authenticate(string $email, string $password): ?Admin
    {
        if ($this->supabaseAuth->isEnabled()) {
            if (! $this->supabaseAuth->isAllowedAdmin($email)) {
                return null;
            }

            $result = $this->supabaseAuth->signIn($email, $password);

            if ($result === null) {
                return null;
            }

            return $this->supabaseAuth->syncAdminFromSupabase($result['user']);
        }

        $admin = Admin::where('email', $email)->first();

        if (! $admin || ! Auth::guard('admin')->getProvider()->validateCredentials($admin, ['password' => $password])) {
            return null;
        }

        return $admin;
    }
}
