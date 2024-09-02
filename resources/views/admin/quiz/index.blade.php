<x-app-layout>
    <div class="flex px-20 py-7 space-x-6">
       @if ($quiz_questions->count() > 0 && $all_options->count() > 0)
            <div class="card w-full bg-white rounded-xl shadow-sm px-8">
                <div class="card-header pb-0 px-3 py-6 flex">
                    <h6 class="mb-0 text-2xl flex-1">Name: {{ $quiz_event->quiz_name }} | Duration: {{ $quiz_event->duration }} mins</h6>
                    <a href="{{ route('admin.quiz-events.delete', $event) }}" class="text-red-500 hover:text-blue-700 underline px-5">Delete</a>
                    <a href="{{ route('admin.quiz-events.edit', $event) }}" class="text-blue-500 hover:text-blue-700 underline">Edit</a>
                </div>
                <div class="card-body pt-4 p-3 ">
                    <ul class="list-group">
                        @foreach ($quiz_questions as $question)
                            <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg rounded-xl">
                                <div class="w-full p-5 text-blue-400 rounded-xl">
                                    <div class="flex items-center pb-4">
                                        <div class="relative">
                                            <h2 class="text-base font-bold text-wave-500">Order: {{ $question->order }}</h2>
                                            <h3 class="text-gray-600">Question: {{ $question->question }}</h3>
                                        </div>
                                    </div>
                                    <div class="pt-2 text-sm font-bold text-gray-500">
                                        <div class="grid grid-cols-4 gap-4">
                                            @foreach ($all_options as $option)
                                                @if ($option->question_id == $question->id)
                                                    <div>
                                                        <h5 class="{{ $option->score == 1 ? 'text-green-900 text-lg' : '' }}">Score: {{ $option->score }}</h5>
                                                        <p class="mb-2 text-lg">Option: {{ $option->option }}</p>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @elseif ($quiz_questions->count() > 0 && $all_options->count() == 0)
            <div class="card w-full bg-white rounded-xl shadow-sm px-8">
                <div class="card-header pb-0 px-3 py-6 flex">
                    <h6 class="mb-0 text-2xl flex-1">Question information</h6>
                    <a href="{{ route('admin.quiz-events.delete', $event) }}" class="text-red-500 hover:text-blue-700 underline px-5">Delete</a>
                    <a href="{{ route('admin.quiz-events.option', $event) }}" class="text-blue-500 hover:text-blue-700 underline">Add Option</a>
                </div>
                <div class="card-body pt-4 p-3 ">
                    <ul class="list-group">
                        @foreach ($quiz_questions as $question)
                            <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg rounded-xl">
                                <div class="w-full p-5 text-blue-400 rounded-xl">
                                    <div class="flex items-center pb-4">
                                        <div class="relative">
                                            <h2 class="text-base font-bold text-wave-500">Order: {{ $question->order }}</h2>
                                            <h3 class="text-gray-600">Question: {{ $question->question }}</h3>
                                            <h3 class="text-gray-600">No Option has been added</h3>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @else
            <div class="card w-full bg-white rounded-xl shadow-sm px-8">
                <div class="card-header pb-0 px-3 py-6 flex">
                    <h6 class="mb-0 text-2xl flex-1">Question information</h6>
                    <a href="{{ route('admin.quiz-events.question', $event) }}" class="text-blue-500 hover:text-blue-700 underline">Create Question</a>
                </div>
                <div class="card-body pt-4 p-3 ">
                    <ul class="list-group">
                        <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg rounded-xl">
                            <h2 class="text-base font-bold text-wave-500">No question has been created</h2>
                        </li>
                    </ul>
                </div>
            </div>
        @endif

    </div>

    @if (session('success'))
    <script>
        alert("{{ session('success') }}")
    </script>
    @elseif (session('failed'))
    <script>
        alert("{{ session('failed') }}")
    </script>
    @endif
</x-app-layout>