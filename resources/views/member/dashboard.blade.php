@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-100">

    {{-- Top Bar --}}
    <div class="d-flex justify-content-between align-items-center bg-white dark:bg-gray-800 shadow px-4 py-3">
        <h2 class="h5 text-danger font-weight-bold">Client Member Dashboard</h2>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-link text-danger p-0">Logout</button>
        </form>
    </div>

    <div class="p-4 space-y-4">

        {{-- Short URLs Section --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="text-primary h6 font-weight-bold">Your Short URLs</h3>
                <a href="{{ route('urls.create') }}" class="btn btn-primary">Create New Short URL</a>
            </div>

            @if ($urls->count() > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Short URL</th>
                            <th>Long URL</th>
                            <th>Hits</th>
                            <th>Created On</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($urls as $url)
                            <tr>
                                <td>
                                    <a href="{{ url($url->short_url) }}" target="_blank">{{ url($url->short_url) }}</a>
                                </td>
                                <td>
                                    <a href="{{ $url->long_url }}" target="_blank">
                                        {{ \Illuminate\Support\Str::limit($url->long_url, 50) }}
                                    </a>
                                </td>
                                <td>{{ $url->hits }}</td>
                                <td>{{ $url->created_at->format('d M Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No short URLs found.</p>
            @endif
        </div>

    </div>
</div>
@endsection
