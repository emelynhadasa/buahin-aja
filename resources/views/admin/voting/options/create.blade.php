<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>
<body>
    <x-app-layout>
        <div class="max-w-3xl mx-auto pt-7">
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 grid gap-4" enctype="multipart/form-data" method="POST" action="{{ route("admin.voting.options.store", $voting->id)}}">
                @csrf
                <input type="hidden" name="voting_id" value="{{ $voting->id }}">
                <div class="mb-4">
                    <label for="text" class="block text-gray-700 text-sm font-bold mb-2">Text</label>
                    <input type="text" id="text" name="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error("text")
                        <p class="text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Image</label>
                    <input type="file" id="image" name="image" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error("image")
                        <p class="text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Submit</button>

            </form>
        </div>

    </x-app-layout>
</body>
</html>