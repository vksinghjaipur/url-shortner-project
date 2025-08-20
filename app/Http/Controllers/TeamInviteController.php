<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class TeamInviteController extends Controller
{
    public function store(Request $request)
    {
        $user = $request->user();

        // Ensure only Admins can invite
        if ($user->role !== 'Admin') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:Admin,Member',
        ]);

        // Create user with inviter's company_id
        $defaultPassword = '12345678';

        $newUser = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'company_id' => $user->company_id,
            'password' => Hash::make($defaultPassword), //Default password by Vikash
        ]);

       
        return redirect()->back()->with('success', 'User invited successfully.');
    }
}
