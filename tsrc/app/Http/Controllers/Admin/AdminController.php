<?php

namespace App\Http\Controllers\Admin;

use App\Channel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $page = [
            'title' => 'Dashboard',
        ];
        $this->authorize('index-admin', Channel::class);

        $stats = [
            'requests_pending' => Channel::pending()->count(),
            'requests_accepted' => Channel::accepted()->count(),
            'requests_rejected' => Channel::rejected()->count(),
            'requests_total' => Channel::all()->count(),
        ];

        $pending_channels = Channel::pending()->get();

        return view('admin.index', compact('page', 'stats', 'pending_channels'));
    }
}
