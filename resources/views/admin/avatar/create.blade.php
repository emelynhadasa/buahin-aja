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
            <form action="{{ route('admin.avatars.store') }}" method="POST" enctype="multipart/form-data"
                class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Avatar name</label>
                        <input type="text" id="name" name="name" placeholder="Avatar name"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label for="type" class="block text-gray-700 text-sm font-bold mb-2">Avatar Type</label>
                        <input type="text" id="type" name="type" placeholder="Avatar type"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></input>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Avatar Image</label>
                    <img id="preview" src="{{ asset('image-preview.png') }}" alt="Preview" class="max-w-28 max-h-28">
                    <input type="file" id="image" name="image" placeholder="Avatar Image"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></input>
                    <p class="text-gray-500 text-xs italic">1 x 1 PNG Image, Max Size 5 MB</p>
                </div>
                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="mx-auto bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Submit</button>
                </div>
            </form>
        </div>

    </x-app-layout>
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

        // Call the displayImage function when the file input changes
        document.getElementById('image').addEventListener('change', function() {
            displayImage(this);
        });
    </script>
</body>

</html>
