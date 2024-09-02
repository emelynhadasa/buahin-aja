<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    @vite('resources/css/app.css')
</head>
<body>
    @auth
    <x-app-layout>
        <div class="max-w-3xl mx-auto pt-7">
            <h1 class="text-2xl font-bold mb-4">Create New Message / Broadcast</h1>
            <form action="{{ route('admin.messages.store') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 grid grid-cols-2 gap-4">
                @csrf
                
                <div class="mb-4 col-span-2">
                    <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title</label>
                    <input type="text" id="title" name="title" placeholder="Title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>

                <div class="mb-4 col-span-2">
                    <label for="content" class="block text-gray-700 text-sm font-bold mb-2">Content</label>
                    <textarea id="content" name="content" placeholder="Content" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
                </div>

                <div class="mb-4">
                    <label for="sender" class="block text-gray-700 text-sm font-bold mb-2">Sender</label>
                    <input type="text" id="sender" name="sender" value="{{ old('sender', $currentUserName) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>

                <div class="mb-4">
                    <label for="to_batch" class="block text-gray-700 text-sm font-bold mb-2">Batch</label>
                    <select id="to_batch" name="to_batch[]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" multiple>
                        <option value="" disabled>Select Batch(s)</option>
                        @foreach($batches as $batch)
                            <option value="{{ $batch->name }}">{{ $batch->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="to_major" class="block text-gray-700 text-sm font-bold mb-2">Major</label>
                    <select id="to_major" name="to_major[]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" multiple>
                        <option value="" disabled>Select Major(s)</option>
                        @foreach($majors as $major)
                            <option value="{{ $major->name }}">{{ $major->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="to_student" class="block text-gray-700 text-sm font-bold mb-2">Student ID(s)</label>
                    <select id="to_student" name="to_student[]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" multiple>
                        <!-- <option value="" selected disabled>Select Student ID(s)</option> -->
                        @foreach($students as $student)
                            <option value="{{ $student->student_id }}">{{ $student->student_id }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center justify-between col-span-2">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Send Message</button>
                </div>
            </form>
            @if ($errors->any())
                <div class="bg-red-500 text-white p-4 rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </x-app-layout>
    @endauth
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#to_batch').select2({
                placeholder: 'Select Batch(s)',
                allowClear: true,
                width: 'resolve'
            });
            
            $('#to_student').select2({
                placeholder: 'Select Student ID(s)',
                allowClear: true,
                width: 'resolve'
            });
            
            $('#to_major').select2({
                placeholder: 'Select Major(s)',
                allowClear: true,
                width: 'resolve'
            });
        });
    </script>
</body>
</html>