<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css') <!-- Include your compiled CSS -->
</head>
<body>
    @auth
    <x-app-layout>
        <div class="container mx-auto py-6">
            <!-- Title and Create New Message link -->
            <div class="text-center pb-6">
                <h1 class="text-2xl font-bold mb-2">Message / Broadcast History</h1>
                <a href="{{ route('admin.messages.create') }}" class="underline text-blue-500 hover:text-blue-700">Create New Message</a>
            </div>

            <!-- Table -->
            <div class="overflow-auto">
                <div class="flex justify-center">
                    <table class="min-w-xl divide-y divide-gray-200 text-center">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">Sender</th>
                                <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">Content</th>
                                <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">To Batch</th>
                                <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">To Major</th>
                                <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">To Student</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($messages as $message)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $message->sender }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $message->title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $message->content }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $message->to_batch }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $message->to_major }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $message->to_student }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </x-app-layout>
    @endauth
</body>
</html>
