<?php

namespace App\Http\Controllers;

use App\Services\Staff\StaffInvitationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StaffInvitationController extends Controller
{
    public function store(Request $request, StaffInvitationService $invitations): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'role' => ['required', Rule::in(['admin', 'staff'])],
            'subject' => ['nullable', 'string', 'max:150'],
            'custom_message' => ['nullable', 'string', 'max:1000'],
        ]);

        try {
            $invitations->send(
                $validated['email'],
                $validated['name'],
                $validated['role'],
                48,
                $validated['subject'] ?? null,
                $validated['custom_message'] ?? null
            );
        } catch (\Throwable $exception) {
            report($exception);

            return back()->withErrors(['invite' => 'The invitation could not be sent. Check the address and mail configuration.'])->withInput();
        }

        return back()->with('status', "Invitation sent to {$validated['email']}.");
    }
}
