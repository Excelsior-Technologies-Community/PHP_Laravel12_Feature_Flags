<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Old Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col font-sans">

    <!-- HEADER -->
    <header class="bg-white shadow p-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">🟡 Old Dashboard</h1>

        <div class="flex gap-3">
            <!-- Feature Panel -->
            <a href="/features" class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-900 transition">
                Manage Features
            </a>

            <!-- Toggle -->
            <a href="/dashboard-toggle" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                Toggle Dashboard
            </a>
        </div>
    </header>

    <!-- ALERT -->
    @if(session('status'))
        <div class="max-w-6xl mx-auto mt-4 px-4">
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
                {{ session('status') }}
            </div>
        </div>
    @endif

    @if(session('success'))
        <div class="max-w-6xl mx-auto mt-4 px-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <!-- MAIN -->
    <main class="flex-1 max-w-6xl mx-auto mt-6 px-4">

        <!-- Welcome -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-2">
                Welcome to the Old Dashboard
            </h2>
            <p class="text-gray-600">
                This is the default dashboard before enabling the new feature.
            </p>
        </div>

        <!-- STATS -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                <h3 class="text-gray-500">Users</h3>
                <p class="text-2xl font-bold">980</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                <h3 class="text-gray-500">Active Features</h3>
                <p class="text-2xl font-bold text-red-600">Limited</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                <h3 class="text-gray-500">Revenue</h3>
                <p class="text-2xl font-bold">$9,850</p>
            </div>

        </div>

        <!-- INFO -->
        <div class="bg-white rounded-lg shadow p-6 mt-6">
            <h3 class="text-lg font-semibold mb-2">About This Dashboard</h3>
            <p class="text-gray-600">
                This is the original version. You can switch to the new dashboard using feature flags.
            </p>
        </div>

    </main>

    <!-- FOOTER -->
    <footer class="bg-white shadow mt-10 p-4 text-center text-gray-500 text-sm">
        &copy; {{ date('Y') }} Laravel Feature Flags Project
    </footer>

</body>

</html>