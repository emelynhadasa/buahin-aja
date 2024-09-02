<x-app-layout>
    <div class="px-32 py-10">
            <h1 class="text-3xl font-bold mb-4 text-gray-800">Quiz Results for {{ $user->first_name }} {{ $user->last_name }}</h1>
            <h3 class="text-xl font-semibold mb-2 text-gray-600">Event Name: <span class="text-gray-800">{{ $event->name }}</span></h3>
            <h3 class="text-xl font-semibold mb-6 text-gray-600">Quiz Name: <span class="text-gray-800">{{ $quiz_event->quiz_name }}</span></h3>

        @foreach($answers as $answer)
            <div class="bg-white shadow overflow-hidden sm:rounded-lg mt-6">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="my-2 text-gray-900 sm:mt-0 sm:col-span-2">
                        <span class="mr-2">{{ $answer->questions->question }}</span>
                    </h3>
                    <ul class="text-gray-800 font-light">
                        @foreach ($options as $key => $rows)
                            @if ($key == $answer->options->question_id)
                                @foreach ($rows as $option)
                                    @if ($answer->options->score == 1 && $option->id == $answer->options->id)
                                        <div class="mt-1 py-1 max-w-auto px-2 rounded-lg bg-green-100">
                                            <span class="mr-2">{{ $option->option }}</span>
                                        </div>
                                    @elseif ($option->id == $answer->options->id && $answer->options->score == 0)
                                        <div class="mt-1 py-1 max-w-auto px-2 rounded-lg bg-red-100">
                                            <span class="mr-2">{{ $option->option }}</span>
                                        </div>
                                    @else
                                        <div class="mt-1 py-1 max-w-auto px-2 rounded-lg">
                                            <span class="mr-2">{{ $option->option }}</span>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach

    </div>
</x-app-layout>