@php
    use Carbon\Carbon;
@endphp

<x-app-layout>
    <div class="flex justify-center items-center w-full h-full px-20 py-7 space-x-6">
        <div class="flex w-2/3 px-20 py-7 space-x-6">
            <div class="card w-full bg-white rounded-xl shadow-sm px-8">
                    <div class="card-header pb-0 px-3 py-6 flex">
                        <h6 class="mb-0 text-2xl flex-1">Name: {{ $quiz_event->quiz_name }} </h6>
                    </div>
                    <form action="{{ route('user.dashboard.store-quiz', $event) }}" method="POST">
                        @csrf
                        <input type="hidden" name="start_time" id="start_time" value="{{ $start_time }}">
                        <div class="card-body pt-4 p-3 ">
                            <ul class="list-group">
                                @foreach ($questions as $question)
                                    <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg rounded-xl">
                                        <div class="w-full p-5 text-blue-400 rounded-xl">
                                            <div class="flex items-center pb-4">
                                                <div class="relative">
                                                    <h2 class="text-base font-bold text-wave-500">Order: {{ $question->order }}</h2>
                                                    <h3 class="text-gray-600">Question: {{ $question->question }}</h3>
                                                </div>
                                            </div>
                                            <div class="pt-2 text-sm font-bold text-gray-500">
                                                @foreach ($options->shuffle() as $option)
                                                    @if ($option->question_id == $question->id)
                                                        <div>
                                                            <input type="radio" value="option_{{ $option->id }}" class="mx-3" id="option{{ $option->id }}" name="question_{{ $option->question_id }}">
                                                            <label for="option{{ $option->id }}" class="mb-2 text-lg">Option: {{ $option->option }}</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        @php
                            $timezone = 'Asia/Bangkok';
                            $now = Carbon::now($timezone);
                        @endphp
                        <input type="hidden" name="end_time" id="end_time" value="{{ $now }}">
                        <button id="submit" class="px-4 py-2 mb-4 bg-blue-500 text-white rounded-md hover:bg-blue-700 transition duration-300 ease-in-out"
                            onclick="end_time()">
                            Submit
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function end_time() {
            
        
        }

    </script>
</x-app-layout>