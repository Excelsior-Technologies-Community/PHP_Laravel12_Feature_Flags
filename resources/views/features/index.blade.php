<!DOCTYPE html>
<html>

<head>
    <title>Feature Flags</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-6">

    <div class="max-w-5xl mx-auto">

        <h2 class="text-2xl font-bold mb-4">🚀 Feature Flags</h2>

        <!-- ALERT -->
        @if(session('success'))
            <div
                class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 flex justify-between items-center">
                <span>{{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="text-xl font-bold">&times;</button>
            </div>
        @endif

        <!-- SEARCH -->
        <form method="GET" class="mb-4">
            <input type="text" name="search" placeholder="Search feature..." class="border p-2 rounded w-1/3">
            <button class="bg-blue-500 text-white px-4 py-2 rounded">
                Search
            </button>
        </form>

        <!-- TABLE -->
        <div class="bg-white shadow rounded">
            <table class="w-full text-left">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-3">ID</th>
                        <th class="p-3">Feature</th>
                        <th class="p-3">Status</th>
                        <th class="p-3">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($features as $feature)
                        <tr class="border-t">
                            <td class="p-3">{{ $feature->id }}</td>
                            <td class="p-3">{{ $feature->feature }}</td>

                            <td class="p-3">
                                @if($feature->active_at)
                                    <span class="text-green-600 font-bold">Enabled</span>
                                @else
                                    <span class="text-red-600 font-bold">Disabled</span>
                                @endif
                            </td>

                            <td class="p-3">
                                <a href="/feature-toggle/{{ $feature->id }}"
                                    class="bg-indigo-500 text-white px-3 py-1 rounded">
                                    Toggle
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <div class="mt-4">
            {{ $features->links() }}
        </div>

    </div>

</body>

</html>