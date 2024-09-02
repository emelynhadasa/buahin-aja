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
            <div class="text-right pb-4">
                <a href="{{ route('admin.publishers.create') }}" class="underline text-blue-500 hover:text-blue-700">Add Publisher</a>
            </div>

            <div class="overflow-auto">
                <table class="min-w-xl divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">Short Name</th>
                            <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">Long Name</th>
                            <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 text-center">
                        @foreach ($publishers as $publisher)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $publisher->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $publisher->short_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $publisher->long_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                        <button class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700 transition duration-300 ease-in-out">
                                            <a href="{{ route('admin.publishers.edit', $publisher) }}">Edit</a>
                                        </button>
                                        <button
                                            class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-700 transition duration-300 ease-in-out">
                                            <a href="{{ route('admin.publishers.destroy', $publisher) }}">Delete</a>
                                        </button>
                                    </td>
    
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </x-app-layout>
    @endauth

</body>
</html>

