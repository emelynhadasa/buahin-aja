<x-app-layout>
    <div class="container mx-auto py-6 px-4">
        <h1 class="text-2xl font-bold">Add Submission Specification for {{ $event->name }}</h1>

        <form action="{{ route('admin.submission-events.store', $event->id) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="submission_name" class="block text-sm font-medium text-gray-700">Submission Name</label>
                <input type="text" name="submission_name" id="submission_name" class="mt-1 block w-full" required>
            </div>
            <div class="mb-4">
                <label for="file_type" class="block text-sm font-medium text-gray-700">File Type</label>
                <input type="text" name="file_type" id="file_type" class="mt-1 block w-full" required>
            </div>
            <div class="mb-4">
                <label for="file_size" class="block text-sm font-medium text-gray-700">File Size (MB)</label>
                <input type="number" name="file_size" id="file_size" class="mt-1 block w-full" required>
            </div>
            <div class="mb-4">
                <label for="desc" class="block text-sm font-medium text-gray-700">Description</label>
                <input type="text" name="desc" id="desc" class="mt-1 block w-full" required>
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
        </form>
    </div>
</x-app-layout>
