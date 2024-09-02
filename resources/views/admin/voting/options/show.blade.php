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
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 grid gap-4" enctype="multipart/form-data" method="POST" action="{{ route("admin.voting.options.update", ["voting" => $voting->id, "option" => $option->id])}}">
                @csrf
                <input type="hidden" name="voting_id" value="{{ $voting->id }}">
                <div class="mb-4">
                    <label for="text" class="block text-gray-700 text-sm font-bold mb-2">Text</label>
                    <input type="text" id="text" name="text" value="{{ $option->text }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
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
        <div class="container mx-auto py-4 max-w-3xl">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <p class="font-bold text-2xl text-blue-500">Showing all votes</p>
                </div>
            </div>
            @error("delete_vote")
                <p class="text-red-500 text-lg font-bold my-2 text-center">{{ $message }}</p>
            @enderror
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">Student ID</th>
                        <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 text-center">
                    @foreach($votes as $vote)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $vote->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $vote->user->student_id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $vote->user->first_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap flex flex-col">
                            <form method="post" action="{{ route("admin.voting.options.vote.delete", ["voting" => $voting->id, "option" => $option->id])}}">
                                @method("delete")
                                @csrf
                                <input type="hidden" name="vote_id" value="{{ $vote->id }}">
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