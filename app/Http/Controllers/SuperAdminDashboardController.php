<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\ShortUrl;
use Carbon\Carbon;

class SuperAdminDashboardController extends Controller
{
    /**
     * Dashboard -> show latest 10 clients & urls (no pagination).
     */
    public function index(Request $request)
    {
        // Handle filter for short URLs
        $filter = $request->query('filter');
        $shortUrlsQuery = ShortUrl::with('company');

        if ($filter) {
            switch ($filter) {
                case 'today':
                    $shortUrlsQuery->whereDate('created_at', Carbon::today());
                    break;
                case 'last_week':
                    $shortUrlsQuery->whereBetween('created_at', [Carbon::now()->subWeek(), Carbon::now()]);
                    break;
                case 'last_month':
                    $shortUrlsQuery->whereMonth('created_at', Carbon::now()->subMonth()->month)
                                   ->whereYear('created_at', Carbon::now()->subMonth()->year);
                    break;
                case 'this_month':
                    $shortUrlsQuery->whereMonth('created_at', Carbon::now()->month)
                                   ->whereYear('created_at', Carbon::now()->year);
                    break;
            }
        }

       
        $shortUrls = $shortUrlsQuery->latest()->take(2)->get();
        $totalShortUrls = ShortUrl::count();

        $clients = Company::withCount('users')
            ->with([
                'users' => function ($query) {
                    $query->withCount('urls')
                          ->withSum('urls as total_hits', 'hits');
                }
            ])
            ->latest()
            ->take(2)
            ->get();
        $totalClients = Company::count();

        return view('dashboard', compact(
            'clients',
            'shortUrls',
            'totalClients',
            'totalShortUrls'
        ));
    }

    
    // V Paginated. 
    public function viewAllClients()
    {
        $clients = Company::withCount('users')
            ->with([
                'users' => function ($query) {
                    $query->withCount('urls')
                          ->withSum('urls as total_hits', 'hits');
                }
            ])
            ->latest()
            ->paginate(10);

        return view('superadmin.clients.index', compact('clients'));
    }

    /**
     * View all short urls -> paginated (with filter).
     */
    public function viewAllUrls(Request $request)
    {
        $filter = $request->query('filter');
        $shortUrlsQuery = ShortUrl::with('company');

        if ($filter) {
            switch ($filter) {
                case 'today':
                    $shortUrlsQuery->whereDate('created_at', Carbon::today());
                    break;
                case 'last_week':
                    $shortUrlsQuery->whereBetween('created_at', [Carbon::now()->subWeek(), Carbon::now()]);
                    break;
                case 'last_month':
                    $shortUrlsQuery->whereMonth('created_at', Carbon::now()->subMonth()->month)
                                   ->whereYear('created_at', Carbon::now()->subMonth()->year);
                    break;
                case 'this_month':
                    $shortUrlsQuery->whereMonth('created_at', Carbon::now()->month)
                                   ->whereYear('created_at', Carbon::now()->year);
                    break;
            }
        }

        $shortUrls = $shortUrlsQuery->latest()->paginate(10);

        return view('superadmin.shorturls.index', compact('shortUrls'));
    }
}
