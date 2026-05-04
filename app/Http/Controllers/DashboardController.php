<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use YlsIdeas\FeatureFlags\Facades\Features;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // Dashboard view
    public function index()
    {
        $sessionToggle = Session::get('new_dashboard_active', null);

        if ($sessionToggle !== null) {
            return $sessionToggle
                ? view('dashboard.new')
                : view('dashboard.old');
        }

        if (Features::accessible('new_dashboard')) {
            return view('dashboard.new');
        }

        return view('dashboard.old');
    }

    // Feature list with search + pagination
    public function features(Request $request)
    {
        $search = $request->search;

        $features = DB::table('features')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {

                    // Text search
                    $q->where('title', 'like', "%$search%")
                        ->orWhere('feature', 'like', "%$search%")
                        ->orWhere('description', 'like', "%$search%");

                    // ✅ STATUS SEARCH
                    if (strtolower($search) == 'enabled') {
                        $q->orWhereNotNull('active_at');
                    }

                    if (strtolower($search) == 'disabled') {
                        $q->orWhereNull('active_at');
                    }
                });
            })
            ->paginate(5)
            ->withQueryString();

        return view('features.index', compact('features'));
    }

    // Toggle feature (DB)
    public function toggleFeature($id)
    {
        $feature = DB::table('features')->where('id', $id)->first();

        if ($feature->active_at) {
            // Disable
            DB::table('features')
                ->where('id', $id)
                ->update(['active_at' => null]);

            $message = "Feature Disabled Successfully!";
        } else {
            // Enable
            DB::table('features')
                ->where('id', $id)
                ->update(['active_at' => now()]);

            $message = "Feature Enabled Successfully!";
        }

        return back()->with('success', $message);
    }
}