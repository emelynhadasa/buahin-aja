<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css') <!-- Include your compiled CSS -->
</head>
<body>
    <x-app-layout>
        <div class="container mx-auto py-4 max-w-3xl">
            <div class="text-right pb-4">
                <a href="{{ route('admin.voting.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Create Voting</a>
            </div>
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                        <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 text-center">
                    @foreach($votings as $voting)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $voting->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $voting->title }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $voting->description }}</td>
                        <td class="px-6 py-4 whitespace-nowrap"><img src="{{ $voting->image_url }}" alt="{{ $voting->title }}" class="w-16 h-16" /></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('admin.voting.show', $voting->id) }}" class="text-blue-500 hover:text-blue-700">Edit</a>
                            <form method="post" action="{{ route("admin.voting.delete", ["voting" => $voting->id])}}">
                                @method("delete")
                                @csrf
                                <button
                                type="submit"
                                    class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-700 transition duration-300 ease-in-out">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-app-layout>
</body>
</html>

