<x-app-layout>
    <div class="flex px-20 py-7 space-x-6">
        <div class="card w-full bg-white rounded-xl shadow-sm px-8">
            <div class="card-header pb-0 px-3 py-6 flex">
                <h6 class="mb-0 text-2xl flex-1">Question information</h6>
            </div>
            <form action="{{ route('admin.quiz-events.store_options', $event) }}" method="POST">
                @csrf
                <div class="card-body pt-4 p-3 ">
                    <ul class="list-group">
                        @if ($quiz_questions)
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($quiz_questions as $question)
                                <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg rounded-xl">
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-3 text-lg">Question {{ $no }} | Order: {{ $question->order }}</h6>
                                        <span class="mb-2 text-sm">{{ $question->question }}</span>
                                        <div class="grid grid-cols-4 gap-4 mt-2">
                                            @for ($i=1; $i<=4; $i++)
                                                <div class="mb-4">
                                                    <div class="flex justify-between items-center mb-2">
                                                        <label for="option{{ $i }}" class="block text-gray-700 text-sm bold">Option {{ $i }}</label>
                                                        <input type="checkbox" id="is_answer{{ $i }}" name="questions[{{ $question->id }}][options][{{ $i }}][is_answer]" value="1" class="mr-2" onchange="updateHiddenInput(this)">
                                                        <input type="hidden" name="questions[{{ $question->id }}][options][{{ $i }}][is_answer]" value="0">
                                                    </div>
                                                    <input type="text" id="option{{ $i }}" name="questions[{{ $question->id }}][options][{{ $i }}][text]" placeholder="Option {{ $i }}" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                                </div>                                         
                                            @endfor 
                                            <input type="hidden" name="question_id" id="question_id" value="{{ $question->id }}">
                                        </div>
                                    </div>
                                </li>
                                @php
                                    $no++;
                                @endphp
                            @endforeach
                        @else
                            <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg rounded-xl">
                                <div class="d-flex flex-column">
                                    <h6 class="mb-3 text-lg">No Question has been created. Make one first!</h6>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
                <div class="flex items-center justify-between">
                    <button type="submit" class="inline-flex items-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white hover:bg-gray-700">
                        Add Quiz
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function updateHiddenInput(checkbox) {
            const hiddenInput = checkbox.nextElementSibling; 
            hiddenInput.value = checkbox.checked ? '1' : '0'; 
        }
    </script>


</x-app-layout>