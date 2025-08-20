<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Get all URLs in the same company (including Member-created)
        $shortUrls = ShortUrl::with('creator')
            ->where('company_id', $user->company_id)
            ->latest()
            ->get();

        // Get all team members (excluding SuperAdmin)
        $teamMembers = User::withCount('urls')
            ->withSum('urls as total_hits', 'hits')
            ->where('company_id', $user->company_id)
            ->whereIn('role', ['Admin', 'Member'])
            ->get();

        return view('admin.dashboard', compact('shortUrls', 'teamMembers'));
    }


    public function downloadUrlsCsv(Request $request)
    {
        $user = auth()->user();

        $query = ShortUrl::with('company')->where('user_id', $user->id);  // filter by logged-in user

        // Apply filter
        if ($request->has('filter')) {
            switch ($request->filter) {
                case 'this_month':
                    $query->whereMonth('created_at', now()->month)
                          ->whereYear('created_at', now()->year);
                    break;
                case 'last_month':
                    $query->whereMonth('created_at', now()->subMonth()->month)
                          ->whereYear('created_at', now()->subMonth()->year);
                    break;
                case 'last_week':
                    $query->whereBetween('created_at', [now()->subWeek(), now()]);
                    break;
                case 'today':
                    $query->whereDate('created_at', now()->toDateString());
                    break;
            }
        }

        $urls = $query->latest()->get();

        $filename = 'short_urls_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($urls) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['Short URL', 'Long URL', 'Hits', 'Client Name', 'Created At']);

            foreach ($urls as $url) {
                fputcsv($file, [
                    route('short.redirect', ['short_url' => $url->short_url]),
                    $url->long_url,
                    $url->hits,
                    $url->company->name ?? 'N/A',
                    $url->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }



}
