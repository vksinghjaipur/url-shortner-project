@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-100">

    {{-- Top Bar --}}
    <div class="d-flex justify-content-between align-items-center bg-white dark:bg-gray-800 shadow px-4 py-3">
        <h2 class="h5 text-primary font-weight-bold">Admin Dashboard</h2>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-link text-danger p-0">Logout</button>
        </form>
    </div>

    <div class="p-4 space-y-4">

        {{-- Generate Short URL --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
            <h3 class="text-primary h6 font-weight-bold mb-3">Generate Short URL</h3>
            <form action="{{ route('urls.store') }}" method="POST" class="d-flex">
                @csrf
                <input type="url" name="long_url" class="form-control mr-2" placeholder="https://sembark.com/travel-software/features/best-itinerary-builder" required>
                <button type="submit" class="btn btn-primary">Generate</button>
            </form>
        </div>

        {{-- Generated Short URLs --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="text-primary h6 font-weight-bold">Generated Short URLs</h3>
                <form action="{{ route('admin.download.urls') }}" method="GET" class="form-inline">
                    <div class="form-group mr-2">
                        <select name="filter" class="form-control" style="min-width: 130px;">
                            <option value="this_month">This Month</option>
                            <option value="last_month">Last Month</option>
                            <option value="last_week">Last Week</option>
                            <option value="today">Today</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Download</button>
                </form>
            </div>
        </div>


            {{-- URLs Table --}}
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Short URL</th>
                        <th>Long URL</th>
                        <th>Hits</th>
                        <th>Created By</th>
                        <th>Created On</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($shortUrls as $url)
                    <tr>
                        <td><a href="{{ route('short.redirect', ['short_url' => $url->short_url]) }}" 
                               target="_blank" 
                               title="{{ $url->long_url }}">
                                {{ url($url->short_url) }}
                            </a>
                        </td>
                        <td>{{ $url->long_url }}</td>
                        <td>{{ $url->hits }}</td>
                        <td>{{ $url->creator->name }}</td>
                        <td>{{ $url->created_at->format('Y-m-d') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Invite Team Member --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
            <h3 class="text-primary h6 font-weight-bold mb-3">Invite New Team Member</h3>
            <form method="POST" action="{{ route('team.invite') }}">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <input type="text" name="name" class="form-control" placeholder="User Name" required>
                    </div>
                    <div class="form-group col-md-4">
                        <input type="email" name="email" class="form-control" placeholder="Email Address" required>
                    </div>
                    <div class="form-group col-md-3">
                        <select name="role" class="form-control" required>
                            <option value="Admin">Admin</option>
                            <option value="Member">Member</option>
                        </select>
                    </div>
                    <div class="form-group col-md-1">
                        <button type="submit" class="btn btn-success">Invite</button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Team Members List --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
            <h3 class="text-primary h6 font-weight-bold mb-3">Team Members</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Total URLs</th>
                        <th>Total Hits</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($teamMembers as $member)
                    <tr>
                        <td>{{ $member->name }}</td>
                        <td>{{ $member->email }}</td>
                        <td>{{ $member->role }}</td>
                        <td>{{ $member->urls_count }}</td>
                        <td>{{ $member->total_hits }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
