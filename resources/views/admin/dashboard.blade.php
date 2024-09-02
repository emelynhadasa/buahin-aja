<x-app-layout>
    <div class="p-20">
        <h1 class="text-3xl font-bold text-center mb-5">Admin Dashboard</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Event List Card -->
            <a href="{{ route('admin.events') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-12 w-12 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
                            <!-- SVG icon here -->
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-xl font-semibold text-gray-800">Event List</h2>
                    </div>
                </div>
            </a>

            <!-- Avatar List Card -->
            <a href="{{ route('admin.avatars') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-12 w-12 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                            <!-- SVG icon here -->
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-xl font-semibold text-gray-800">Avatar List</h2>
                    </div>
                </div>
            </a>

            <!-- Major List Card -->
            <a href="{{ route('admin.majors') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-12 w-12 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                            <!-- SVG icon here -->
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-xl font-semibold text-gray-800">Major List</h2>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.batches') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-12 w-12 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                            <!-- SVG icon here -->
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-xl font-semibold text-gray-800">Batch List</h2>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.news') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-12 w-12 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                            <!-- SVG icon here -->
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-xl font-semibold text-gray-800">News List</h2>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.publishers') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-12 w-12 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                            <!-- SVG icon here -->
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-xl font-semibold text-gray-800">Publisher List</h2>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.categories') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-12 w-12 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                            <!-- SVG icon here -->
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-xl font-semibold text-gray-800">Category List</h2>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.types') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-12 w-12 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                            <!-- SVG icon here -->
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-xl font-semibold text-gray-800">Type List</h2>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.users') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-12 w-12 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                            <!-- SVG icon here -->
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-xl font-semibold text-gray-800">User List</h2>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.voting') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-12 w-12 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                            <!-- SVG icon here -->
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-xl font-semibold text-gray-800">Voting List</h2>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.messages') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-12 w-12 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                            <!-- SVG icon here -->
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-xl font-semibold text-gray-800">Message List</h2>
                    </div>
                </div>
            </a>
        </div>

        <!-- Floating Button -->
        <a href="{{ route('admin.messages.create') }}" class="fixed bottom-8 right-8 bg-[#2AB976] text-white text-lg font-semibold rounded-full shadow-lg py-3 px-6 flex items-center">
            <span class="mr-2">💬</span> Create Message
        </a>
    </div>
</x-app-layout>
