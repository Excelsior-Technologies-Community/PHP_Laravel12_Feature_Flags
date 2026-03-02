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