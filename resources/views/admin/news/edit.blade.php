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

                <div class="max-w-2xl mx-auto bg-white p-6 rounded-md shadow-md">
                    <h1 class="text-2xl font-bold mb-4 text-center">Edit News</h1>
                    <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="title" name="title" value="{{ old('title', $news->title) }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="type" class="block text-gray-700 text-sm font-bold mb-2">Type</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="type" name="type" value="{{ old('type', $news->type) }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                            <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="description" name="description" rows="3" required>{{ old('description', $news->description) }}</textarea>
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
                            <input type="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="publish_date" name="publish_date" value="{{ old('publish_date', $news->publish_date) }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="image" class="block text-gray-700 text-sm font-bold mb-2">News Image</label>
                            <img id="preview" src="{{ $news->image ?? asset('image-preview.png') }}" alt="Preview" class="mx-auto mb-4 max-w-xs">
                            <input type="file" id="image" name="image" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" onchange="displayImage(this)">
                            <p class="text-gray-500 text-xs italic mt-2">1 x 1 PNG Image, Max Size 5 MB</p>
                        </div>

                        <div class="mb-4">
                            <label for="order_number" class="block text-gray-700 text-sm font-bold mb-2">Order Number</label>
                            <input type="number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="order_number" name="order_number" value="{{ old('order_number', $news->order_number) }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="status" name="status" required>
                                <option value="active" {{ old('status', $news->status) == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="expired" {{ old('status', $news->status) == 'Expired' ? 'selected' : '' }}>Expired</option>
                            </select>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700 transition duration-300 ease-in-out">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </x-app-layout>
    @endauth

    <script>
        function displayImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview').src = e.target.result;
                    document.getElementById('preview').style.display = 'block';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        document.getElementById('image').addEventListener('change', function() {
            displayImage(this);
        });
    </script>
</body>
</html>
