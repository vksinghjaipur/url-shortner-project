<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class ShortUrlRedirectController extends Controller
{
    public function redirect($short_url)
    {
        $shortUrl = ShortUrl::where('short_url', $short_url)->first();

        if (!$shortUrl) {
            abort(404, 'Short URL not found.');
        }

        $shortUrl->increment('hits');

        return redirect()->away($shortUrl->long_url);
    }
}

