@php
    use Carbon\Carbon;

    $timezone = 'Asia/Bangkok';
    $now = Carbon::now($timezone);
@endphp

<x-app-layout>
    <div class="mt-8 mx-8">

        <div class="mb-5">
            <h1 class="text-xl font-bold mb-2">{{ $event->name }}</h1>
            <div>
                <p><span class="font-bold">Category:</span> {{$event->category->name}}</p>
                <p><span class="font-bold">Description:</span><br>{{ $event->description }}</p>
                <p><span class="font-bold">Point:</span> {{ $event->point }}</p>
                <p><span class="font-bold">Total Progress:</span> {{ $event->target }}</p>
                <p><span class="font-bold">Maximum Participants:</span> {{ $event->max_participants }}</p>
                <p><span class="font-bold">Start Date:</span> {{ $event->start }}</p>
                <p><span class="font-bold">End Date:</span> {{ $event->end }}</p>
                <p><span class="font-bold">Requirement:</span>
                    @foreach ($event->majors as $major)
                        {{ $major->name }}
                    @endforeach
                    @foreach ($event->batches as $batch)
                        {{ $batch->name }}
                    @endforeach
                </p> 
                <p><span class="font-bold">Type:</span> {{ $event->type->id }} | {{ $event->type->name }}</p>
                <img src="{{ asset($event->image) }}" alt="preview img" class="max-w-56 max-h-56">
            </div>
        </div>
    
        <div class="">
            <button id="participate_button" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700 transition duration-300 ease-in-out" data-time="{{ $now }}">
                Participate
            </button>
        </div>
    </div>

    <script>
        document.getElementById('participate_button').addEventListener('click', function(event) {
            event.preventDefault(); 
            if (confirm('The duration for this quiz is {{ $quiz_event->duration }}. Once you click play, the timer will be started')) {
                const currentTime = event.target.getAttribute('data-time');
                const url = new URL("{{ route('user.play-quiz', $event) }}");
                url.searchParams.append('start_time', currentTime);

                window.location.href = url.toString();
            }
        });
    </script>


</x-app-layout>