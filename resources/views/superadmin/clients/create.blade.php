@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center bg-white dark:bg-gray-800 shadow px-4 py-3">
    <a href="{{ route('dashboard') }}" class="h5 text-danger font-weight-bold">Super Admin Dashboard</a>

    <form method="POST" action="{{ route('logout') }}" class="mb-0">
        @csrf
        <button class="btn btn-link text-danger p-0">Logout</button>
    </form>
</div>

<div class="container mt-4">
    <h3>Invite New Client</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('clients.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="company_name">Client Name</label>
            <input type="text" name="company_name" class="form-control" required placeholder="Enter company name">
        </div>

        <div class="form-group mt-3">
            <label for="email">Admin Email</label>
            <input type="email" name="email" class="form-control" required placeholder="admin@example.com">
        </div>

        <button type="submit" class="btn btn-primary mt-4">Send Invitation</button>
    </form>
</div>
@endsection
