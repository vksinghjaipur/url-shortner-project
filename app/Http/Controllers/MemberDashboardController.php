<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShortUrl;

class MemberDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Get URLs only created by this member
        $urls = ShortUrl::where('user_id', $user->id)->get();

        return view('member.dashboard', compact('urls'));
    }
}
