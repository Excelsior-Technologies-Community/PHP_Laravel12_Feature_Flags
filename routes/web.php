<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index']);

Route::get('/features', [DashboardController::class, 'features']);

Route::post('/feature-toggle/{id}', [DashboardController::class, 'toggleFeature'])->name('features.toggle');

Route::get('/dashboard-toggle', function () {
    $current = Session::get('new_dashboard_active', false);
    Session::put('new_dashboard_active', !$current);

    $status = !$current ? 'New Dashboard Enabled' : 'Old Dashboard Enabled';
    return redirect('/dashboard')->with('status', $status);
});

Route::get('/feature-logs/{feature}', [DashboardController::class, 'viewLogs'])->name('features.logs');