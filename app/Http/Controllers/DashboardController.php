<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use YlsIdeas\FeatureFlags\Facades\Features;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    // Dashboard view with Targeting and A/B Testing
    public function index()
    {
        $sessionToggle = Session::get('new_dashboard_active', null);

        if ($sessionToggle !== null) {
            return $sessionToggle ? view('dashboard.new') : view('dashboard.old');
        }

        // Logic for A/B Testing and Targeting
        if ($this->isFeatureAccessible('new_dashboard')) {
            return view('dashboard.new');
        }

        return view('dashboard.old');
    }

    // Check if feature is accessible based on targeting and traffic
    private function isFeatureAccessible($featureName)
    {
        $feature = DB::table('features')->where('feature', $featureName)->first();
        
        if (!$feature || !$feature->active_at) return false;

        // A/B Testing Check
        if ($feature->traffic_percentage < 100) {
            if (rand(1, 100) > $feature->traffic_percentage) return false;
        }

        // User-Specific Targeting Check
        if ($feature->allowed_roles) {
            $roles = json_decode($feature->allowed_roles, true);
            if (!in_array(auth()->user()->role, $roles)) return false;
        }

        return true;
    }

    // Feature list with search + pagination
    public function features(Request $request)
    {
        $search = $request->search;
        $features = DB::table('features')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%$search%")
                      ->orWhere('feature', 'like', "%$search%");
                });
            })
            ->paginate(5)
            ->withQueryString();

        return view('features.index', compact('features'));
    }

    // Toggle feature with Audit Logging
    public function toggleFeature($id)
    {
        $feature = DB::table('features')->where('id', $id)->first();
        $user = auth()->user()->name ?? 'System';

        if ($feature->active_at) {
            DB::table('features')->where('id', $id)->update(['active_at' => null]);
            $action = 'disabled';
        } else {
            DB::table('features')->where('id', $id)->update(['active_at' => now()]);
            $action = 'enabled';
        }

        // Audit Log entry
        DB::table('feature_audit_logs')->insert([
            'feature_name' => $feature->feature,
            'action'       => $action,
            'changed_by'   => $user,
            'created_at'   => now()
        ]);

        return back()->with('success', "Feature " . ucfirst($action) . " Successfully!");
    }

    // Function to fetch and show audit logs for a specific feature
    public function viewLogs($featureName)
    {
        // Get logs from the audit table, ordered by newest first
        $logs = DB::table('feature_audit_logs')
                  ->where('feature_name', $featureName)
                  ->latest()
                  ->paginate(10);

        // Return the view (Make sure you have created resources/views/features/logs.blade.php)
        return view('features.logs', compact('logs', 'featureName'));
    }
}