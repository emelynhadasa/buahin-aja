<x-app-layout>
    <div class="container mx-auto py-6 px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">{{ $event->name }} - Submission Specifications</h1>
            <a href="{{ url('admin/events') }}" class="px-4 py-2 bg-gray-600 text-white rounded">Back to Events</a>
        </div>

        @if ($submissionEvents->isEmpty())
            <a href="{{ route('admin.submission-events.create', $event->id) }}" class="underline text-blue-500 hover:text-blue-700">Add Submission Specification</a>
        @endif

        <div class="mt-4">
            @foreach ($submissionEvents as $submissionEvent)
                <div class="bg-white rounded p-4 mb-4">
                    <h2 class="text-lg font-semibold">{{ $submissionEvent->submission_name }}</h2>
                    <p>File Type: {{ $submissionEvent->file_type }}</p>
                    <p>File Size: {{ $submissionEvent->file_size }} MB</p>
                    <p>Description: {{ $submissionEvent->desc }}</p>
                    <div class="mt-2">
                        <a href="{{ route('admin.submission-events.edit', [$event->id, $submissionEvent->id]) }}" class="underline text-blue-500 hover:text-blue-700">Edit</a>
                        <a href="{{ route('admin.submission-events.delete', [$event->id, $submissionEvent->id]) }}" class="underline text-red-500 hover:text-red-700 ml-2">Delete</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @if (session('success'))
        <script>
            alert("{{ session('success') }}");
        </script>
    @elseif (session('failed'))
        <script>
            alert("{{ session('failed') }}");
        </script>
    @endif
</x-app-layout>
