<x-app-layout>
    <div class="flex px-20 py-7 space-x-6">
        <div class="card w-full bg-white rounded-xl shadow-sm px-8">
            <div class="card-header pb-0 px-3 py-6 flex">
                <h6 class="mb-0 text-2xl flex-1">Question information</h6>
            </div>
            <form action="{{ route('admin.quiz-events.update', $event) }}" method="POST">
                @csrf
                <div class="card-body pt-4 p-3 ">
                     <div class="grid grid-cols-5 gap-4">
                        <div class="mb-4 ">
                            <label for="quiz_name" class="block text-gray-700  text-sm font-bold mb-2">Quiz Name</label>
                            <input type="text" id="quiz_name" name="quiz_name" value="{{ $quiz_event->quiz_name }}" placeholder="Quiz Name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required {{ $quiz_event->quiz_name ? 'selected' : '' }}>
                        </div>
                        <div class="mb-4">
                            <label for="duration" class="block text-gray-700 text-sm font-bold mb-2">Duration</label>
                            <input type="text" id="duration" name="duration" value="{{ $quiz_event->duration }}" placeholder="In Game Duration" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required {{ $quiz_event->duration ? 'selected' : '' }}>
                        </div>
                    </div>
                    <ul class="list-group">
                        @php
                            $grouped_options = $all_options->groupBy('question_id');
                            $no = 1;
                        @endphp
                        @foreach ($quiz_questions as $question)
                            <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg rounded-xl">
                                <div class="d-flex flex-column">
                                    <h6 class="mb-3 text-lg">Question {{ $no }} | Order: {{ $question->order }}</h6>
                                    <label for="question{{ $question->id }}">Question:</label>
                                    <input type="text" id="question{{ $question->id }}" name="questions[{{ $question->id }}][question]" value="{{ $question->question }}" class="border-none bg-transparent outline-none w-1/2">
                                    <div class="grid grid-cols-4 gap-4 mt-2">
                                        @if (isset($grouped_options[$question->id]))
                                            @foreach ($grouped_options[$question->id] as $index => $option)
                                                <div class="mb-4">
                                                    <div class="flex justify-between items-center mb-2">
                                                        <label for="option{{ $question->id }}_{{ $index }}" class="block text-gray-700 text-sm bold">Option {{ $index+1 }}</label>
                                                        <input type="checkbox" id="is_answer{{ $question->id }}_{{ $index+1 }}" name="questions[{{ $question->id }}][options][{{ $index }}][is_answer]" value="1" class="mr-2" onchange="updateHiddenInput(this, '{{ $question->id }}_{{ $index }}')" {{ $option->score == 1 ? 'checked' : '' }}>
                                                        <input type="hidden" id="hidden_is_answer{{ $question->id }}_{{ $index}}" name="questions[{{ $question->id }}][options][{{ $index }}][is_answer]" value="{{ $option->score }}">
                                                    </div>
                                                    <input type="text" id="option{{ $question->id }}_{{ $index }}" name="questions[{{ $question->id }}][options][{{ $index }}][text]" placeholder="Option {{ $index+1 }}" value="{{ $option->option }}" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                                </div>
                                            @endforeach

                                        @endif
                                        <input type="hidden" name="question_id" id="question_id" value="{{ $question->id }}">
                                    </div>
                                </div>
                            </li>
                            @php
                                $no++;
                            @endphp
                        @endforeach
                    </ul>
                </div>
                <div class="flex items-center justify-between">
                    <button type="submit" class="inline-flex items-center rounded-md border border-transparent bg-gray-800 px-4 py-2 mb-4 text-xs font-semibold uppercase tracking-widest text-white hover:bg-gray-700">
                        Update Quiz
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function updateHiddenInput(checkbox, id) {
            const hiddenInput = document.getElementById('hidden_is_answer' + id);
            hiddenInput.value = checkbox.checked ? '1' : '0';
        }
    </script>


</x-app-layout>