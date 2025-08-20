@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-100">

    {{-- Top Bar --}}
    <div class="d-flex justify-content-between align-items-center bg-white dark:bg-gray-800 shadow px-4 py-3">
        @php
            // Force lowercase to avoid case mismatch
            $role = strtolower(auth()->user()->role);
            $dashboardRoute = match($role) {
                'admin' => route('admin.dashboard'),
                'member' => route('member.dashboard'),
                default => route('dashboard'), // Only SuperAdmin
            };
        @endphp

        <a href="{{ $dashboardRoute }}" class="text-decoration-none">
            <h2 class="h5 text-danger font-weight-bold mb-0">
                {{ ucfirst($role) }} Dashboard
            </h2>
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-link text-danger p-0" type="submit">
                Logout
            </button>
        </form>
    </div>

    {{-- Page Content --}}
    <div class="container py-5">
        <h3 class="mb-4 font-weight-bold">Generate Short URL</h3>

        {{-- Error Display --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- URL Form --}}
        <form method="POST" action="{{ route('urls.store') }}">
            @csrf

            <div class="form-group">
                <label for="long_url">Long URL</label>
                <input
                    type="url"
                    name="long_url"
                    id="long_url"
                    class="form-control"
                    required
                    placeholder="https://example.com"
                    value="{{ old('long_url') }}"
                >
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Generate Short URL</button>
                <a href="{{ route('urls.index') }}" class="btn btn-secondary ml-2">Back to List</a>
            </div>
        </form>
    </div>
</div>
@endsection
