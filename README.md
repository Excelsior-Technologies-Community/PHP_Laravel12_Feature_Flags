# PHP_Laravel12_Feature_Flags

## Project Introduction

In modern application development, deploying new features safely and efficiently is crucial. Feature flags allow developers to control which features are visible or active for users, providing flexibility, safety, and the ability to experiment in real-time.

PHP_Laravel12_Feature_Flags is designed as a learning and demonstration tool to show:

- How to install and configure the ylsideas/feature-flags package in Laravel 12

- How to define feature flags in database, configuration, or session

- How to implement conditional rendering in controllers and Blade templates

- How to switch features dynamically without modifying or redeploying code

- How to structure a Laravel project for clean, maintainable feature flag usage

---

## Project Overview

PHP_Laravel12_Feature_Flags is a Laravel 12 demonstration project that showcases the use of feature flags (feature toggles) to dynamically enable or disable application features without requiring code deployment.

Feature flags are widely used in modern software development to:

- Gradually release new features to selected users

- Perform A/B testing for improved user experience

- Reduce risk by controlling feature access in production

- Simplify testing and experimentation without deploying multiple code versions

This project implements a dashboard system where the “Old Dashboard” and “New Dashboard” can be toggled dynamically. It demonstrates how feature flags can be integrated with:

- Laravel controllers

- Blade views

- Session-based toggles and .env configuration

- Clean, responsive UI using Tailwind CSS

---

## Step 1: Create Laravel 12 Project

Open terminal and run:

```bash
composer create-project laravel/laravel PHP_Laravel12_Feature_Flags "12.*"
cd PHP_Laravel12_Feature_Flags
```

This creates a fresh Laravel 12 project.

---

## Step 2: Install Feature Flags Package

We’ll use ylsideas/feature-flags package:

```bash
composer require ylsideas/feature-flags
```

---

## Step 3: Publish Configuration and Migration

```bash
php artisan vendor:publish --provider="YlsIdeas\FeatureFlags\FeatureFlagsServiceProvider"
php artisan migrate
```

This creates:

config/features.php – configuration file for feature flags.

features table – stores flags in the database.

---

## Step 4: Configure .env


```.env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=feature_flags_db
DB_USERNAME=root
DB_PASSWORD=

FEATURE_NEW_DASHBOARD=true
FEATURE_BETA_FEATURE=false
FEATURE_SCHEDULED_TASK=true
```

---

## Step 5: Configure Feature Flags

Edit config/features.php:

```php
<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Pipeline
    |--------------------------------------------------------------------------
    |
    | The pipeline for the feature to travel through.
    |
    */

   'pipeline' => ['database', 'in_memory'],

 //  'pipeline' => ['in_memory'], // remove 'database' temporarily

    /*
    |--------------------------------------------------------------------------
    | Gateways
    |--------------------------------------------------------------------------
    |
    | Configures the different gateway options
    |
    */

    'gateways' => [
        'in_memory' => [
            'file' => env('FEATURE_FLAG_IN_MEMORY_FILE', '.features.php'),
            'driver' => 'in_memory',
        ],
        'database' => [
            'driver' => 'database',
            'cache' => [
                'ttl' => 600,
            ],
            'connection' => env('FEATURE_FLAG_DATABASE_CONNECTION'),
            'table' => env('FEATURE_FLAG_DATABASE_TABLE', 'features'),
        ],
        'gate' => [
            'driver' => 'gate',
            'gate' => env('FEATURE_FLAG_GATE_GATE', 'feature'),
            'guard' => env('FEATURE_FLAG_GATE_GUARD'),
            'cache' => [
                'ttl' => 600,
            ],
        ],
        'redis' => [
            'driver' => 'redis',
            'prefix' => env('FEATURE_FLAG_REDIS_PREFIX', 'features'),
            'connection' => env('FEATURE_FLAG_REDIS_CONNECTION', 'default'),
        ],
    ],

    'flags' => [
        'new_dashboard' => [
            'description' => 'Enable the new dashboard design',
            'default' => true,
        ],
        'beta_feature' => [
            'description' => 'Enable beta feature for testing',
            'default' => false,
        ],
    ],
];
```

---

## Step 6: Create Controller

```bash
php artisan make:controller DashboardController
```

app/Http/Controllers/DashboardController.php:

```php
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
```

---

## Step 7: Create Blade Views

### New Dashboard

resources/views/dashboard/new.blade.php:

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col font-sans">

    <!-- Header -->
    <header class="bg-white shadow p-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">New Dashboard</h1>
        <a href="/dashboard-toggle" 
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
           Toggle Dashboard
        </a>
    </header>

    <!-- Status Message -->
    @if(session('status'))
        <div class="max-w-6xl mx-auto mt-4 px-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                {{ session('status') }}
            </div>
        </div>
    @endif

    <!-- Dashboard Content -->
    <main class="flex-1 max-w-6xl mx-auto mt-6 px-4">

        <!-- Welcome Card -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-2">Welcome to your new dashboard!</h2>
            <p class="text-gray-600">Here you can see your latest stats and manage features dynamically using feature flags.</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                <h3 class="text-gray-500 font-medium">Users</h3>
                <p class="text-2xl font-bold text-gray-800">1,245</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                <h3 class="text-gray-500 font-medium">Active Features</h3>
                <p class="text-2xl font-bold text-gray-800">8</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                <h3 class="text-gray-500 font-medium">Revenue</h3>
                <p class="text-2xl font-bold text-gray-800">$12,450</p>
            </div>
        </div>

        <!-- Info Section -->
        <div class="bg-white rounded-lg shadow p-6 mt-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">About Feature Flags</h3>
            <p class="text-gray-600">
                Feature flags allow you to enable or disable specific functionality dynamically without deploying new code.
                Use them to gradually release features, test in production, and control experiments safely.
            </p>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-white shadow mt-10 p-4 text-center text-gray-500 text-sm">
        &copy; {{ date('Y') }} My Laravel Dashboard. All rights reserved.
    </footer>

</body>
</html>
```


### Old Dashboard

resources/views/dashboard/old.blade.php:

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Old Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col font-sans">

    <!-- Header -->
    <header class="bg-white shadow p-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">Old Dashboard</h1>
        <a href="/dashboard-toggle" 
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
           Toggle Dashboard
        </a>
    </header>

    <!-- Status Message -->
    @if(session('status'))
        <div class="max-w-6xl mx-auto mt-4 px-4">
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative">
                {{ session('status') }}
            </div>
        </div>
    @endif

    <!-- Dashboard Content -->
    <main class="flex-1 max-w-6xl mx-auto mt-6 px-4">

        <!-- Welcome Card -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-2">Welcome to the Old Dashboard</h2>
            <p class="text-gray-600">This is the original dashboard layout. It represents the default view before enabling the new feature.</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                <h3 class="text-gray-500 font-medium">Users</h3>
                <p class="text-2xl font-bold text-gray-800">980</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                <h3 class="text-gray-500 font-medium">Active Features</h3>
                <p class="text-2xl font-bold text-gray-800">5</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                <h3 class="text-gray-500 font-medium">Revenue</h3>
                <p class="text-2xl font-bold text-gray-800">$9,850</p>
            </div>
        </div>

        <!-- Info Section -->
        <div class="bg-white rounded-lg shadow p-6 mt-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">About This Dashboard</h3>
            <p class="text-gray-600">
                This is the original dashboard layout. You can toggle to the new dashboard to see enhanced design and features enabled via feature flags.
            </p>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-white shadow p-4 text-center text-gray-500 text-sm">
        &copy; {{ date('Y') }} My Laravel Dashboard. All rights reserved.
    </footer>

</body>
</html>
```

---

## Step 8: Define Routes

routes/web.php:

```php
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index']);

// Toggle route
Route::get('/dashboard-toggle', function () {
    // Switch current dashboard flag
    $current = Session::get('new_dashboard_active', false);
    Session::put('new_dashboard_active', !$current);

    $status = !$current ? 'New Dashboard Enabled' : 'Old Dashboard Enabled';
    return redirect('/dashboard')->with('status', $status);
});


Route::get('/', function () {
    return view('welcome');
});
```

---

## Step 9: Test the Project

Start Laravel server:

```bash
php artisan serve
```

Go to:

```bash
http://127.0.0.1:8000/dashboard
```

Shows current dashboard (Old or New based on session or feature flag).

Go to:

```bash
http://127.0.0.1:8000/dashboard-toggle
```
Dashboard will switch.

Refresh /dashboard → you see the new one.

---

## Output

### New Dashboard

<img width="1919" height="1029" alt="Screenshot 2026-03-02 173450" src="https://github.com/user-attachments/assets/ebb16736-38dd-4bb6-9144-0ac093279963" />

### Old Dashboard

<img width="1915" height="1025" alt="Screenshot 2026-03-02 173502" src="https://github.com/user-attachments/assets/88fd736c-3670-44b6-b19c-2948761792da" />

---

## Project Structure

```
PHP_Laravel12_Feature_Flags/
├── app/
│   └── Http/
│       └── Controllers/
│           └── DashboardController.php
├── config/
│   └── features.php
├── database/
│   └── migrations/
├── resources/
│   └── views/
│       └── dashboard/
│           ├── old.blade.php
│           └── new.blade.php
├── routes/
│   └── web.php
├── artisan
├── composer.json
└── README.md
```

---

Your PHP_Laravel12_Feature_Flags Project is now ready!
