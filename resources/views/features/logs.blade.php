<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit Logs - {{ $featureName }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 min-h-screen p-6">

    <div class="max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                Audit Logs: <span class="text-indigo-600">{{ ucfirst($featureName) }}</span>
            </h2>
            <a href="/features" class="bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-gray-900 transition text-sm">
                &larr; Back to Features
            </a>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
            <table class="w-full text-left">
                <thead class="bg-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="p-4 text-sm font-semibold text-gray-600 uppercase tracking-wider">Action</th>
                        <th class="p-4 text-sm font-semibold text-gray-600 uppercase tracking-wider">Changed By</th>
                        <th class="p-4 text-sm font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($logs as $log)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4">
                            <span class="px-2 py-1 rounded text-xs font-bold 
                                {{ $log->action == 'enabled' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ strtoupper($log->action) }}
                            </span>
                        </td>
                        <td class="p-4 text-gray-700 font-medium">{{ $log->changed_by }}</td>
                        <td class="p-4 text-gray-500 text-sm">{{ \Carbon\Carbon::parse($log->created_at)->format('d M, Y - H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="p-6 text-center text-gray-500">No logs found for this feature.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $logs->links() }}
        </div>
    </div>

</body>
</html> 