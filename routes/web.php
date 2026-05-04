<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/features', [DashboardController::class, 'features']);
Route::get('/feature-toggle/{id}', [DashboardController::class, 'toggleFeature']);

// Session toggle
Route::get('/dashboard-toggle', function () {
    $current = Session::get('new_dashboard_active', false);
    Session::put('new_dashboard_active', !$current);

    $status = !$current ? 'New Dashboard Enabled' : 'Old Dashboard Enabled';
    return redirect('/dashboard')->with('status', $status);
});

Route::get('/', function () {
    return view('welcome');
});
