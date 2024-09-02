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
                <a href="{{ route('admin.news.create') }}" class="underline text-blue-500 hover:text-blue-700">Add News</a>
            </div>
            <div class="overflow-auto">
                <table class="min-w-xl divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider"> ID</th>
                            <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">News Title</th>
                            <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">Publisher</th>
                            <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">Publish Date</th>
                            <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                            <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">Order Number</th>
                            <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                            <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 text-center">
                        @foreach ($news as $news)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $news->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $news->title }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $news->type }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ Str::limit($news->description, 30) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $news->publisher }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $news->publish_date }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $news->image }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $news->order_number }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $news->status }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $news->created_at }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                        <button class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700 transition duration-300 ease-in-out">
                                            <a href="{{ route('admin.news.edit', $news) }}">Edit</a>
                                        </button>
                                        <button
                                            class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-700 transition duration-300 ease-in-out">
                                            <a href="{{ route('admin.news.destroy', $news) }}">Delete</a>
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

