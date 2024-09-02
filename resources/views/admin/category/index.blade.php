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
            <div class="container mx-auto py-6 flex flex-wrap">
                <div class="w-full md:w-3/4 px-4">
                    <form action="#" method="GET" class="mb-4">
                        @csrf
                        <input type="text" id="search" placeholder="Search category..." class="px-4 py-2 border rounded">
                    </form>
                    <table class="category-table min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider"> ID
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name</th>
                                <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 text-center">
                            @foreach ($categories as $category)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $category->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $category->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <button class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700 transition duration-300 ease-in-out">
                                            <a href="{{ route('admin.categories.edit', $category) }}">Edit</a>
                                        </button>
                                        <button
                                            class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-700 transition duration-300 ease-in-out">
                                            <a href="{{ route('admin.categories.delete', $category) }}">Delete</a>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="w-full md:w-1/4 px-4">
                    <form action="{{ route('admin.categories.store') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                            <input type="text" id="name" name="name" placeholder="Name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Submit</button>
                        </div>
                    </form>
                </div>
                    
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const searchInput = document.getElementById('search');
                    const tableRows = document.querySelectorAll('.category-table tbody tr');

                    searchInput.addEventListener('input', function() {
                        const query = this.value.toLowerCase();

                        tableRows.forEach(row => {
                            let rowVisible = false;

                            row.querySelectorAll('td').forEach(cell => {
                                const cellText = cell.textContent.toLowerCase();
                                if (cellText.includes(query)){
                                    rowVisible = true;
                                }
                            });

                            if (rowVisible) {
                                row.style.display = '';
                            } else {
                                row.style.display = 'none';
                            }

                        });
                    });
                });
            </script>

        </x-app-layout>
    @endauth
</body>

</html>
