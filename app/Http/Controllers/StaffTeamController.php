<?php

namespace App\Http\Controllers;

use App\Models\StaffActivityLog;
use App\Models\StaffInvitation;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StaffTeamController extends Controller
{
    public function index(): View
    {
        return view('staff.team', [
            'members' => User::query()->whereIn('role', ['admin', 'staff'])->orderBy('name')->get(),
            'invitations' => StaffInvitation::query()->latest()->limit(20)->get(),
        ]);
    }

    public function revoke(Request $request, User $user): RedirectResponse
    {
        abort_if($request->user()->is($user), 422, 'You cannot revoke your own access.');
        abort_if($user->role === 'admin' && User::where('role', 'admin')->where('is_active', true)->count() <= 1, 422, 'The last active administrator cannot be revoked.');

        $user->update(['is_active' => false]);
        $user->tokens()->delete();
        StaffActivityLog::create(['user_id' => $request->user()->id, 'action' => 'staff.access_revoked', 'subject_type' => User::class, 'subject_id' => $user->id]);

        return back()->with('status', "Access revoked for {$user->email}.");
    }

    public function restore(Request $request, User $user): RedirectResponse
    {
        $user->update(['is_active' => true]);
        StaffActivityLog::create(['user_id' => $request->user()->id, 'action' => 'staff.access_restored', 'subject_type' => User::class, 'subject_id' => $user->id]);

        return back()->with('status', "Access restored for {$user->email}.");
    }

    public function revokeInvitation(Request $request, StaffInvitation $invitation): RedirectResponse
    {
        abort_if($invitation->accepted_at !== null, 422, 'An accepted invitation cannot be revoked.');
        $invitation->update(['revoked_at' => now()]);
        StaffActivityLog::create(['user_id' => $request->user()->id, 'action' => 'staff.invitation_revoked', 'subject_type' => StaffInvitation::class, 'subject_id' => $invitation->id]);

        return back()->with('status', "Invitation revoked for {$invitation->email}.");
    }
}
