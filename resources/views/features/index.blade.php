<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feature Flags</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-6">

    <div class="max-w-6xl mx-auto">

        <h2 class="text-2xl font-bold mb-4">🚀 Feature Flags Management</h2>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 flex justify-between items-center">
                <span>{{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="text-xl font-bold">&times;</button>
            </div>
        @endif

        <form method="GET" class="mb-4 flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search feature..." class="border p-2 rounded w-1/3">
            <button class="bg-blue-500 text-white px-4 py-2 rounded">Search</button>
            <a href="/features" class="bg-gray-500 text-white px-4 py-2 rounded">Reset</a>
        </form>

        <div class="bg-white shadow rounded overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-3">Feature</th>
                        <th class="p-3">Status</th>
                        <th class="p-3">Targeting (Roles)</th>
                        <th class="p-3">Traffic</th>
                        <th class="p-3">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($features as $feature)
                        <tr class="border-t">
                            <td class="p-3 font-medium">{{ $feature->feature }}</td>
                            
                            <td class="p-3">
                                @if($feature->active_at)
                                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-bold">Enabled</span>
                                @else
                                    <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-bold">Disabled</span>
                                @endif
                            </td>

                            <td class="p-3 text-sm text-gray-600">
                                {{ $feature->allowed_roles ? implode(', ', json_decode($feature->allowed_roles, true)) : 'All' }}
                            </td>

                            <td class="p-3 text-sm font-semibold text-purple-600">
                                {{ $feature->traffic_percentage }}%
                            </td>

                            <td class="p-3 flex gap-2">
                                <form action="{{ route('features.toggle', $feature->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-indigo-500 text-white px-3 py-1 rounded text-sm hover:bg-indigo-600">
                                        Toggle
                                    </button>
                                </form>

                                <a href="{{ route('features.logs', $feature->feature) }}" 
                                   class="bg-gray-500 text-white px-3 py-1 rounded text-sm hover:bg-gray-600">
                                    View Logs
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $features->links() }}
        </div>

    </div>

</body>
</html>