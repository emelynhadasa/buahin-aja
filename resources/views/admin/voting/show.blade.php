<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <x-app-layout>
        <div class="max-w-3xl mx-auto pt-7">
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 grid gap-4" enctype="multipart/form-data" method="POST" action="{{ route("admin.voting.update", [$voting->id])}}">
                @csrf
                @method("patch")
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title</label>
                    <input type="text" id="title" name="title" value="{{ $voting->title }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error("title")
                        <p class="text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="type" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                    <textarea type="text" id="description" name="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $voting->description }}</textarea>
                    @error("description")
                        <p class="text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="event_id" class="block text-gray-700 text-sm font-bold mb-2">Event</label>
                    <select id="event_id" name="event_id" value="{{ $voting->event_id }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @foreach ($events as $event)
                            <option value="{{ $event->id }}">{{ $event->name }}</option>
                        @endforeach
                    </select>
                    @error("event_id")
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
                    <p class="font-bold text-2xl text-blue-500">Showing all voting options</p>
                    
                </div>
                <div>
                    <a href="{{ route('admin.voting.options.create', $voting->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Create Voting</a>
                </div>
            </div>
            @error("voted")
                <p class="text-red-500 text-lg font-bold my-2 text-center">{{ $message }}</p>
            @enderror
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">Text</th>
                        <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">Total Votes</th>
                        <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                        <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 text-center">
                    @foreach($options as $option)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $option->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $option->text }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $option->votes->count() }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($option->image_url)
                            <img src="{{ $option->image_url }}" alt="{{ $option->text }}" class="w-16 h-16" />
                            @else
                            <span>No image</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap flex flex-col gap-4">
                            <a href="{{ route('admin.voting.options.show', ["voting" => $voting->id, "option" => $option->id]) }}" class="text-blue-500 hover:text-blue-700">Edit</a>
                            <form id="vote-form-{{ $option->id }}" onsubmit="vote(event)" method="post" action="{{ route('admin.voting.options.vote', ["voting" => $voting->id, "option" => $option->id]) }}">
                                @csrf
                                <input type="hidden" id="student_id" name="student_id" value="{{ auth()->user()->id }}" />
                                <input type="hidden" id="option_id" name="option_id" value="{{ $option->id }}" />
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Vote</button>
                            </form>
                            <form method="post" action="{{ route("admin.voting.options.delete", ["voting" => $voting->id, "option" => $option->id])}}">
                                @method("delete")
                                @csrf
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
    <script>
        const students = @json($students)


        const studentsObject = students.reduce((acc, student) => {
            acc[student.id] = student.first_name;
            return acc;
        }, {});



        async function vote(event) {
            event.preventDefault();
            const { value: student } = await Swal.fire({
                title: "Select student to force vote",
                input: "select",
                inputOptions: {
                    Students: studentsObject,
                },
                inputPlaceholder: "Select a student",
                showCancelButton: true,
            });

            if(!student) {
                Swal.fire({
                    icon: "error",
                    title: "You need to select a student to force vote",
                })

                return;
            }

            const option = event.target.querySelector("#option_id").value;
            const voteForm = document.getElementById("vote-form-" + option);
            const voteStudent = event.target.querySelector("#student_id");
            voteStudent.value = student;

            voteForm.submit();
        }

    </script>
</body>
</html>