<?php

namespace App\Http\Controllers;

use App\Models\StaffInvitation;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class StaffAuthController extends Controller
{
    public function loginForm(): View
    {
        return view('staff.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate(['email' => ['required', 'email'], 'password' => ['required', 'string']]);

        if (! Auth::attempt([...$credentials, 'is_active' => true], $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'These credentials do not match an active staff account.'])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('staff.dashboard'));
    }

    public function acceptForm(string $token): View
    {
        return view('staff.accept-invitation', ['token' => $token, 'invitation' => $this->invitation($token)]);
    }

    public function accept(Request $request, string $token): RedirectResponse
    {
        $invitation = $this->invitation($token);
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'password' => ['required', 'confirmed', Password::min(10)->letters()->mixedCase()->numbers()],
        ]);

        $user = DB::transaction(function () use ($invitation, $validated): User {
            $user = User::updateOrCreate(
                ['email' => $invitation->email],
                [
                    'name' => $validated['name'],
                    'password' => $validated['password'],
                    'role' => $invitation->role,
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]
            );
            $invitation->update(['accepted_at' => now()]);

            return $user;
        });

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('staff.dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    private function invitation(string $token): StaffInvitation
    {
        $invitation = StaffInvitation::where('token_hash', hash('sha256', $token))->firstOrFail();
        abort_unless($invitation->isUsable(), 410, 'This invitation has expired or has already been used.');

        return $invitation;
    }
}
