@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-100">

    {{-- Top Bar --}}
    <div class="d-flex justify-content-between align-items-center bg-white dark:bg-gray-800 shadow px-4 py-3 border-bottom border-warning" style="border-width: 3px;">
        <div class="d-flex align-items-center">

            @php
                $user = Auth::user();
                $dashboardName = 'Dashboard';
                $dashboardRoute = '#';

                if ($user->role === 'SuperAdmin') {
                    $dashboardName = 'Super Admin Dashboard';
                    $dashboardRoute = route('dashboard');
                } elseif ($user->role === 'Admin') {
                    $dashboardName = 'Admin Dashboard';
                    $dashboardRoute = route('admin.dashboard');
                } elseif ($user->role === 'Member') {
                    $dashboardName = 'Member Dashboard';
                    $dashboardRoute = route('member.dashboard');
                }
            @endphp

          
            <h2 class="h5 text-danger font-weight-bold mb-0">
                <a href="{{ $dashboardRoute }}" class="text-danger text-decoration-none">{{ $dashboardName }}</a>
            </h2>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-link text-danger p-0">Logout &rarr;</button>
        </form>
    </div>



    <div class="p-4">

        {{-- Clients Card --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">

            {{-- Header --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="text-primary h6 font-weight-bold">Clients</h3>
                <a href="{{ route('clients.create') }}" class="btn btn-outline-primary btn-sm">Invite</a>
            </div>

            {{-- Table --}}
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Client Name</th>
                        <th>Users</th>
                        <th>Total Generated URLs</th>
                        <th>Total URL Hits</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($clients as $client)
                        <tr>
                            <td>
                                {{ $client->name }}<br>
                                <small class="text-muted">{{ $client->email }}</small>
                            </td>
                            <td>{{ $client->users_count }}</td>
                            <td>{{ $client->total_urls }}</td>
                            <td>{{ $client->total_hits }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No clients found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="d-flex justify-content-between align-items-center mt-3">
                <small class="text-muted">
                    Showing {{ $clients->count() }} of total {{ $clients->total() }}
                </small>

                <div>
                    {{ $clients->onEachSide(1)->links('pagination::bootstrap-4') }}
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
