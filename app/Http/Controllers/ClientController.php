<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    
    public function index()
    {
        $clients = Company::whereHas('users', function ($query) {
                $query->where('role', 'Admin');
            })
            ->withCount([
                'users' => function ($query) {
                    $query->where('role', 'Admin');
                }
            ])
            ->withSum('urls as total_hits', 'hits') 
            ->withCount('urls')
            ->paginate(2);

        return view('superadmin.clients.index', compact('clients'));
    }


        
    // Show the Invite New Client
    public function create()
    {
        return view('superadmin.clients.create');
    }


    // Store new company and admin user
    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255|unique:companies,name',
            'email' => 'required|email|unique:users,email',
        ]);

        $company = Company::create([
            'name' => $request->company_name,
        ]);

        //$tempPassword = Str::random(10);
        $defaultPassword = '12345678';

        $admin = User::create([
            'name' => $request->company_name . ' Admin',
            'email' => $request->email,
            'password' => Hash::make($defaultPassword),
            'role' => 'Admin',
            'company_id' => $company->id,
        ]);

        //dd($admin);

        return redirect()->route('clients.create')->with('success', 'Client and Admin created successfully.');

    }
}

