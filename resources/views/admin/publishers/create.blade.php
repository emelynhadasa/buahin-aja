<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>
<body>
    @auth
    <x-app-layout>
        <div class="max-w-3xl mx-auto pt-7">
            <h1 class="text-2xl font-bold mb-4">Create Publishers</h1>
            <form action="{{ route('admin.publishers.store') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 grid grid-cols-2 gap-4">
                @csrf
                <div class="mb-4">
                    <label for="short_name" class="block text-gray-700 text-sm font-bold mb-2">Short Name</label>
                    <input type="text" id="short_name" name="short_name" placeholder="Publisher Short Name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label for="long_name" class="block text-gray-700 text-sm font-bold mb-2">Long Name</label>
                    <input type="text" id="long_name" name="long_name" placeholder="Publisher Long Name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Submit</button>
                </div>
            </form>
        </div>
    </x-app-layout>
    @endauth
</body>
</html>
