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
                <div class="max-w-2xl mx-auto bg-white p-6 rounded-md shadow-md">
                    <h1 class="text-2xl font-bold mb-4 text-center">Edit Publishers</h1>
                    <form action="{{ route('admin.publishers.update', $publisher) }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                        @csrf
                        @method('PUT')
                    <div class="mb-4">
                        <label for="short_name" class="block text-gray-700 text-sm font-bold mb-2">Short Name</label>
                        <input value="{{ $publisher->short_name }}" type="text" id="short_name" name="short_name"
                            placeholder="Publisher Short Name"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label for="type" class="block text-gray-700 text-sm font-bold mb-2">Long Name</label>
                        <input value="{{ $publisher->long_name }}" type="text" id="long_name" name="long_name"
                            placeholder="Publisher Long Name"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></input>
                    </div>

                        <div class="text-center">
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700 transition duration-300 ease-in-out">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </x-app-layout>
    @endauth
</body>
</html>
