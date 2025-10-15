<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\Invitation;
use App\Models\Company;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class InvitationController extends BaseController
{
    /**
     * Show invitation list
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // SuperAdmin sees all invitations
        if ($user->hasRole('SuperAdmin')) {
            $invitations = Invitation::with(['company', 'role', 'inviter'])->latest()->get();
        }
       
        elseif ($user->hasRole('Admin')) {
            $invitations = Invitation::with(['company', 'role', 'inviter'])
                ->where('company_id', $user->company_id)
                ->latest()->get();
        } else {
            abort(403, 'You are not authorized to view invitations.');
        }

        // AJAX for DataTable
        if ($request->ajax()) {
            return response()->json(['data' => $invitations]);
        }

        return view('admin.invitations.index');
    }


    public function create()
    {
        $user = Auth::user();

        if (! $user->hasAnyRole(['SuperAdmin', 'Admin'])) {
            abort(403, 'You are not allowed to create invitations.');
        }

        // SuperAdmin: invite Admin in a NEW company
        if ($user->hasRole('SuperAdmin')) {
            $roles = Role::where('name', 'Admin')->get();
            $companies = Company::all();
        }
        // Admin: invite Admin/Member in their OWN company
        else {
            $roles = Role::whereIn('name', ['Admin', 'Member'])->get();
            $companies = collect(); // no dropdown for Admin
        }

        return view('admin.invitations.create', compact('roles', 'companies'));
    }


    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->hasRole('SuperAdmin')) {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:invitations,email',
                'role_id' => 'required|exists:roles,id',
                'company_id' => 'required|exists:companies,id',
            ]);

            $companyId = $request->company_id;
        } elseif ($user->hasRole('Admin')) {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:invitations,email',
                'role_id' => 'required|exists:roles,id',
            ]);

            $companyId = $user->company_id;
        } else {
            abort(403);
        }

        $invitation = Invitation::create([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'company_id' => $companyId,
            'invited_by' => $user->id,
        ]);
//         $token = Str::random(40);
// $invitation->update(['token' => $token]);
// Mail::to($invitation->email)->send(new InvitationMail($invitation));

        return redirect()
            ->route('admin.invitations.index')
            ->with('success', 'Invitation created successfully.');
    }
    public function approve($id)
    {
        $user = Auth::user();
        $invitation = Invitation::with(['role', 'company'])->findOrFail($id);

        if (! $user->hasAnyRole(['SuperAdmin', 'Admin'])) {
            abort(403, 'You are not authorized to approve invitations.');
        }

        if ($invitation->status === 'Approved') {
            return back()->with('info', 'Invitation is already approved.');
        }

        $newUser = \App\Models\User::create([
            'name' => $invitation->name,
            'email' => $invitation->email,
            'password' => bcrypt('password'), // default or generated
            'company_id' => $invitation->company_id,
            'status'=>1,
            'role_id' => $invitation->role_id,
        ]);

        $invitation->update([
            'status' => 'Approved',
        ]);

        return redirect()->route('admin.invitations.index')
                        ->with('success', 'Invitation approved and user account created.');
    }
}


