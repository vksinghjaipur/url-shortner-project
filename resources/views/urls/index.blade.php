@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-100">

    {{-- Top Bar --}}
    <div class="d-flex justify-content-between align-items-center bg-white dark:bg-gray-800 shadow px-4 py-3 border-bottom border-warning" style="border-width: 3px;">
        <div class="d-flex align-items-center">
            <h2 class="h5 text-danger font-weight-bold mb-0">Super Admin Dashboard</h2>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-link text-danger p-0">Logout &rarr;</button>
        </form>
    </div>

    {{-- Content --}}
    <div class="p-4">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="text-primary h6 font-weight-bold mb-0">All Short URLs</h3>
                <form method="GET" class="d-flex align-items-center">
                    <select name="filter" class="form-control form-control-sm me-2" onchange="this.form.submit()">
                        <option value="">--  Select Filter --</option>
                        <option value="this_month" {{ request('filter') == 'this_month' ? 'selected' : '' }}>This Month</option>
                        <option value="last_month" {{ request('filter') == 'last_month' ? 'selected' : '' }}>Last Month</option>
                        <option value="last_week" {{ request('filter') == 'last_week' ? 'selected' : '' }}>Last Week</option>
                        <option value="today" {{ request('filter') == 'today' ? 'selected' : '' }}>Today</option>
                    </select>

                    {{-- Dynamic download link with current filter --}}
                    <a href="{{ route('urls.download', ['filter' => request('filter')]) }}" class="btn btn-outline-primary btn-sm ml-2">
                        Download CSV
                    </a>
                </form>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($shortUrls->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover text-sm">
                        <thead>
                            <tr>
                                <th>Short URL</th>
                                <th>Original URL</th>
                                <th>Hits</th>
                                <th>Client Name</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($shortUrls as $url)
                                <tr>
                                    <td>
                                        @if ($url->short_url)
                                            <a href="{{ route('short.redirect', ['short_url' => $url->short_url]) }}" target="_blank">
                                                {{ route('short.redirect', ['short_url' => $url->short_url]) }}
                                            </a>
                                        @else
                                            <span class="text-danger">Invalid</span>
                                        @endif
                                    </td>
                                    <td class="text-truncate" style="max-width:250px;">
                                        <a href="{{ $url->long_url }}" target="_blank">
                                            {{ \Illuminate\Support\Str::limit($url->long_url, 60) }}
                                        </a>
                                    </td>
                                    <td>{{ $url->hits }}</td>
                                    <td>{{ $url->company->name ?? 'N/A' }}</td>
                                    <td>{{ $url->created_at->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-center">No short URLs found.</p>
            @endif

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $shortUrls->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
