<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col font-sans">

    <header class="bg-white shadow p-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">🚀 New Dashboard</h1>

        <div class="flex gap-3">
            <a href="/features" class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-900 transition">
                Manage Features
            </a>
            <a href="/dashboard-toggle" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                Toggle Dashboard
            </a>
        </div>
    </header>

    @if(session('status') || session('success'))
        <div class="max-w-6xl mx-auto mt-4 px-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('status') ?? session('success') }}
            </div>
        </div>
    @endif

    <main class="flex-1 max-w-6xl mx-auto mt-6 px-4">

        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-2">
                Welcome to your new dashboard!
            </h2>
            <p class="text-gray-600">
                This dashboard includes advanced feature flag controls including User Targeting, A/B Testing, and Audit Logging.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-gray-500 text-sm uppercase">Total Users</h3>
                <p class="text-2xl font-bold">1,245</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-gray-500 text-sm uppercase">Access Type</h3>
                <p class="text-lg font-bold text-blue-600">{{ auth()->user()->role ?? 'Standard' }}</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-gray-500 text-sm uppercase">Traffic Segment</h3>
                <p class="text-lg font-bold text-purple-600">Active (A/B Test)</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-gray-500 text-sm uppercase">Audit Status</h3>
                <p class="text-lg font-bold text-green-600">Logging Enabled</p>
            </div>

        </div>

        <div class="bg-white rounded-lg shadow p-6 mt-6">
            <h3 class="text-lg font-semibold mb-2">Advanced Feature Control</h3>
            <div class="space-y-4 text-gray-600">
                <p>
                    <span class="font-bold text-blue-800">Targeting:</span> Only authorized roles (e.g., Admin) see specific blocks.
                </p>
                <p>
                    <span class="font-bold text-purple-800">A/B Testing:</span> Traffic is being segmented dynamically based on database configuration.
                </p>
                <p>
                    <span class="font-bold text-green-800">Audit Logs:</span> All toggling actions are currently being tracked in the <code>feature_audit_logs</code> table.
                </p>
            </div>
        </div>

    </main>

    <footer class="bg-white shadow mt-10 p-4 text-center text-gray-500 text-sm">
        &copy; {{ date('Y') }} Laravel Advanced Feature Flags
    </footer>

</body>
</html>