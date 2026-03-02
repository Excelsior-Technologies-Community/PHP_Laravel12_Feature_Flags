<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use YlsIdeas\FeatureFlags\Facades\Features;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index()
    {
        // Check session toggle first
        $sessionToggle = Session::get('new_dashboard_active', null);
        if ($sessionToggle !== null) {
            return $sessionToggle
                ? view('dashboard.new')
                : view('dashboard.old');
        }

        // Fallback to feature flag
        if (Features::accessible('new_dashboard')) {
            return view('dashboard.new'); // New dashboard
        }

        return view('dashboard.old'); // Old dashboard
    }
}