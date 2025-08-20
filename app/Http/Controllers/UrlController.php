<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShortUrl;

class UrlController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        if ($user->role === 'SuperAdmin') {
            $query = ShortUrl::with('company');

           
            if ($request->has('filter')) {
                switch ($request->filter) {
                    case 'this_month':
                        $query->whereMonth('created_at', now()->month);
                        break;
                    case 'last_month':
                        $query->whereMonth('created_at', now()->subMonth()->month);
                        break;
                    case 'last_week':
                        $query->whereBetween('created_at', [now()->subWeek(), now()]);
                        break;
                    case 'today':
                        $query->whereDate('created_at', now()->toDateString());
                        break;
                }
            }

            $shortUrls = $query->latest()->paginate(10);
            return view('urls.index', compact('shortUrls'));
        }

       
        if ($user->role === 'Admin') {
            $shortUrls = ShortUrl::where('company_id', $user->company_id)->latest()->paginate(10);
            return view('urls.index', compact('shortUrls'));
        }

       
        if ($user->role === 'Member') {
            $shortUrls = ShortUrl::where('user_id', $user->id)->latest()->paginate(10);
            return view('urls.index', compact('shortUrls'));
        }

        abort(403, 'Unauthorized access.');
    }


    public function create()
    {
        $user = auth()->user();

        if ($user->role === 'SuperAdmin') {
            abort(403, 'SuperAdmin cannot create short URLs.');
        }

        return view('urls.create');
    }

    // public function store(Request $request)
    // {
        
    //     //echo '<pre>'; print_r($request->all()); die();
    //     //dd($request->all());

    //     $user = auth()->user();

    //     if ($user->role === 'SuperAdmin') {
    //         abort(403, 'SuperAdmin cannot create short URLs.');
    //     }

    //     $request->validate([
    //         'long_url' => 'required|url|max:2048',
    //     ]);

    //     // Generate unique short_url
    //     $shortUrlCode = substr(md5(uniqid(rand(), true)), 0, 6);


    //     ShortUrl::create([
    //         'short_url' => $shortUrlCode,
    //         'long_url' => $request->long_url,
    //         'user_id' => $user->id,
    //         'company_id' => $user->company_id,
    //         'hits' => 0,
    //     ]);

    //     return redirect()->route('urls.index')->with('success', 'Short URL created!');
    // }


    public function store(Request $request)
    {
        $user = auth()->user();

        //dd($user->company_id); 
        
        // SuperAdmin cannot create short URLs
        if ($user->role === 'SuperAdmin') {
            abort(403, 'SuperAdmin cannot create short URLs.');
        }

        
        $request->validate([
            'long_url' => 'required|url|max:2048',
        ]);

      
        $shortUrlCode = substr(md5(uniqid(rand(), true)), 0, 6);

        
        ShortUrl::create([
            'short_url' => $shortUrlCode,
            'long_url' => $request->long_url,
            'user_id' => $user->id,
            'company_id' => $user->company_id,
            'hits' => 0,
        ]);

        
        if ($user->role === 'Admin') {
            return redirect()->route('admin.dashboard')->with('success', 'Short URL created successfully!');
        } elseif ($user->role === 'Member') {
            return redirect()->route('member.dashboard')->with('success', 'Short URL created successfully!');
        }

       
        return redirect()->route('dashboard')->with('success', 'Short URL created successfully!');
    }



    /**
     * Public redirect method for short URLs
     */
    public function redirect($shortUrlCode)
    {
        $shortUrl = ShortUrl::where('short_url', $shortUrlCode)->firstOrFail();

        // Increment hit count
        $shortUrl->increment('hits');

        return redirect()->to($shortUrl->long_url);
    }



    public function download(Request $request)
    {
        $user = auth()->user();

        // Only SuperAdmin can download
        if ($user->role !== 'SuperAdmin') {
            abort(403, 'Only Super Admin can download.');
        }

        $query = ShortUrl::with('company');

        // Apply filter
        if ($request->has('filter')) {
            switch ($request->filter) {
                case 'this_month':
                    $query->whereMonth('created_at', now()->month);
                    break;
                case 'last_month':
                    $query->whereMonth('created_at', now()->subMonth()->month);
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

            // Header row
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
