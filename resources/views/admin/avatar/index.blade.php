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
                    <a href="{{ route('admin.avatars.create') }}" class="underline text-blue-500 hover:text-blue-700">Add
                        Avatar</a>
                </div>

                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider"> ID
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Avatar Type</th>
                            <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Avatar Name</th>
                            <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Avatar Image</th>
                            <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 text-center">
                        @foreach ($avatars as $avatar)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $avatar->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $avatar->type }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $avatar->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <img class="h-16 w-16 mx-auto" src="{{ $avatar->image }}" />
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700 transition duration-300 ease-in-out">
                                        <a href="{{ route('admin.avatars.edit', $avatar) }}">Edit</a>
                                    </button>
                                    <button
                                        class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-700 transition duration-300 ease-in-out">
                                        <a href="{{ route('admin.avatars.destroy', $avatar) }}">Delete</a>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-app-layout>
    @endauth

</body>

</html>
