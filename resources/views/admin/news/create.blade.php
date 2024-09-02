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
            <h1 class="text-2xl font-bold mb-4">Create News</h1>
            <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 grid grid-cols-2 gap-4">
                @csrf
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title</label>
                    <input type="text" id="title" name="title" placeholder="Title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label for="type" class="block text-gray-700 text-sm font-bold mb-2">Type</label>
                    <input type="text" id="type" name="type" placeholder="Type" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4 col-span-2">
                    <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                    <textarea id="description" name="description" placeholder="Description" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
                </div>
                <div class="mb-4">
                    <label for="publisher" class="block text-gray-700 text-sm font-bold mb-2">Publisher</label>
                    <select id="publisher" name="publisher" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <option value="" disabled selected>Select Publisher</option>
                        @foreach($publishers as $publisher)
                            <option value="{{ $publisher->long_name }}">{{ $publisher->long_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="publish_date" class="block text-gray-700 text-sm font-bold mb-2">Publish Date</label>
                    <input type="date" id="publish_date" name="publish_date" placeholder="Publish Date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4 col-span-2">
                    <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Image</label>
                    <input type="file" id="image" name="image" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="order_number" class="block text-gray-700 text-sm font-bold mb-2">Order Number</label>
                    <input type="number" id="order_number" name="order_number" placeholder="Order Number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                    <select id="status" name="status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <option value="active">Active</option>
                        <option value="expired">Expired</option>
                    </select>
                </div>
                <div class="flex items-center justify-between col-span-2">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Submit</button>
                </div>
            </form>
        </div>
    </x-app-layout>
    @endauth
</body>
</html>
