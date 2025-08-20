@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-100">

    {{-- Top Bar --}}
    <div class="d-flex justify-content-between align-items-center bg-white dark:bg-gray-800 shadow px-4 py-3">
        <h2 class="h5 text-danger font-weight-bold">Super Admin Dashboard</h2>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-link text-danger p-0">Logout</button>
        </form>
    </div>

    <div class="p-4 space-y-4">

        {{-- Clients Section --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="text-primary h6 font-weight-bold">Clients</h3>
                <a href="{{ route('clients.create') }}" class="btn btn-primary btn-sm">Invite</a>
            </div>

            <table class="table table-hover">
                <thead>
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

            {{-- Showing + View All --}}
            <div class="d-flex justify-content-start align-items-center mt-3">
                <small class="text-muted">
                    Showing {{ $clients->count() }} of total {{ $totalClients }}
                </small>
                <a href="{{ route('clients.index') }}" class="btn btn-sm btn-outline-primary ms-3">
                    View All
                </a>
            </div>

        </div>

        {{-- Generated Short URLs Section --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="text-primary h6 font-weight-bold">Generated Short URLs</h3>
                <form method="GET" class="form-inline">
                    <div class="form-group mr-2">
                        <select name="filter" class="form-control form-control-sm" onchange="this.form.submit()">
                            <option value="">-- Select Filter --</option>
                            <option value="this_month" {{ request('filter') == 'this_month' ? 'selected' : '' }}>This Month</option>
                            <option value="last_month" {{ request('filter') == 'last_month' ? 'selected' : '' }}>Last Month</option>
                            <option value="last_week" {{ request('filter') == 'last_week' ? 'selected' : '' }}>Last Week</option>
                            <option value="today" {{ request('filter') == 'today' ? 'selected' : '' }}>Today</option>
                        </select>
                    </div>
                    <a href="{{ route('urls.download', ['filter' => request('filter')]) }}" class="btn btn-outline-primary btn-sm ml-2">
                        Download CSV
                    </a>
                </form>
            </div>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Short URL</th>
                        <th>Long URL</th>
                        <th>Hits</th>
                        <th>Client Name</th>
                        <th>Created On</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($shortUrls as $url)
                        <tr>
                            <td>{{ url($url->short_url) }}</td>
                            <td class="text-truncate" style="max-width:250px;">{{ $url->long_url }}</td>
                            <td>{{ $url->hits }}</td>
                            <td>{{ $url->company->name ?? 'N/A' }}</td>
                            <td>{{ $url->created_at->format('d-M-Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No URLs found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Showing + View All --}}
            <div class="d-flex justify-content-start align-items-center mt-3">
                <small class="text-muted">
                    Showing {{ $shortUrls->count() }} of total {{ $totalShortUrls }}
                </small>
                <a href="{{ route('urls.index') }}" class="btn btn-sm btn-outline-primary ms-3">
                    View All
                </a>
            </div>

        </div>

    </div>
</div>
@endsection
