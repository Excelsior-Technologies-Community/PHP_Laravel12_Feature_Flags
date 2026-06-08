<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Old Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col font-sans">

    <header class="bg-white shadow p-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">🟡 Old Dashboard</h1>

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
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
                {{ session('status') ?? session('success') }}
            </div>
        </div>
    @endif

    <main class="flex-1 max-w-6xl mx-auto mt-6 px-4">

        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-2">
                Welcome to the Old Dashboard
            </h2>
            <p class="text-gray-600">
                This is the legacy version. Advanced targeting, A/B testing, and audit logs are not active in this view.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-gray-500 text-sm uppercase">Total Users</h3>
                <p class="text-2xl font-bold">980</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-gray-500 text-sm uppercase">Access Type</h3>
                <p class="text-lg font-bold text-gray-600">Standard</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-gray-500 text-sm uppercase">Traffic Segment</h3>
                <p class="text-lg font-bold text-red-600">Legacy Mode</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-gray-500 text-sm uppercase">Audit Status</h3>
                <p class="text-lg font-bold text-gray-600">Disabled</p>
            </div>

        </div>

        <div class="bg-white rounded-lg shadow p-6 mt-6">
            <h3 class="text-lg font-semibold mb-2">About This Dashboard</h3>
            <p class="text-gray-600">
                This is the original version. Advanced features like role-based targeting and audit logs require you to switch to the new dashboard interface.
            </p>
        </div>

    </main>

    <footer class="bg-white shadow mt-10 p-4 text-center text-gray-500 text-sm">
        &copy; {{ date('Y') }} Laravel Feature Flags Project
    </footer>

</body>
</html>