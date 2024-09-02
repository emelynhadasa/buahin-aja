@php
    use Illuminate\Support\Str;
    use Carbon\Carbon;
@endphp

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @vite('resources/css/app.css') <!-- Include your compiled CSS -->
</head>
<body>
    @auth
    <x-app-layout>
        <div class="container mx-auto py-6 px-4">
            <div class="text-right pb-4">
                <a href="{{ route('admin.events.create') }}" class="inline-block underline text-blue-500 hover:text-blue-700">Add Event</a>
            </div>

            <div class="flex justify-left items-center">
                <form action="#" method="GET" class="mb-4">
                    @csrf
                    <input type="text" id="search" placeholder="Search Event Name..." class="px-4 py-2 border rounded">
                </form>
                <div class="mb-3 mx-4">
                    <label class="items-center space-x-2">
                        <input type="checkbox" id="pending" class="form-checkbox">
                        <span>Pending</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" id="ongoing" class="form-checkbox">
                        <span>Ongoing</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" id="end" class="form-checkbox">
                        <span>End</span>
                    </label>
                </div>
            </div>
            <div class="grid grid-cols-4 gap-4">
                @foreach ($events->chunk(2) as $chunk)
                    @foreach ($chunk as $event)
                        @php
                            // converting time from string to date
                            $timezone = 'Asia/Bangkok';
                            $start = Carbon::parse($event->start, $timezone);
                            $end = Carbon::parse($event->end, $timezone);
                            $now = Carbon::now($timezone);
                        @endphp

                        <section class="event-item">
                            <div class="bg-white rounded-sm p-2 hover:-translate-y-1 transition duration-300">
                                <img src="{{ asset($event->image) }}" alt="Preview Image" class="w-auto h-52 mb-2 rounded-sm">
                                <h2 class="text-lg text-indigo-800">{{ $event->id }} | {{ $event->category->name }} | {{ $event->name }} </h2>
                                <p class="text-gray-600">Description: {{ Str::limit($event->description, 20) }}</p>
                                <p>Point: {{ $event->point }}</p>
                                <p>Type: {{ $event->type->name }}</p>
                                <p class="status mb-1">Status: 
                                    @if ($now->gt($start) && $now->lt($end))
                                        Ongoing
                                    @elseif ($now->lt($start))
                                        Pending
                                    @elseif ($now->gt($end))
                                        End
                                    @endif
                                </p>
                                <div class="">
                                    <button class="text-white bg-purple-600 pt-1 pb-2 rounded-md px-2 cursor-pointer transition duration-300 ease-in-out hover:bg-purple-800 showDetail" data-event-id="{{ $event->id }}">See Details</button>
                                    @if ($event->type_id == 1)
                                        <button class="text-white bg-blue-600 pt-1 pb-2 rounded-md px-2 cursor-pointer transition duration-300 ease-in-out hover:bg-blue-800 createGame" data-game-type="{{ $event->type->name }}" data-event-id="{{ $event->id }}">Create Game</button>
                                    @elseif ($event->type_id == 2)
                                        <a href="{{ route('admin.submission-events', $event->id) }}" class="text-white bg-green-600 pt-1 pb-2 rounded-md px-2 cursor-pointer transition duration-300 ease-in-out hover:bg-green-800">Create Submission</a>
                                    @endif
                                </div>
                            </div>
                        </section>
                    @endforeach
                @endforeach
            </div>

        </div>
        <script>

            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('search');
                const ongoingStatus = document.getElementById('ongoing');
                const endStatus = document.getElementById('end');
                const pendingStatus = document.getElementById('pending');
                const eventItems = document.querySelectorAll('.event-item');

                function updateDisplay() {
                    const query = searchInput.value.toLowerCase();
                    const anyCheckboxChecked = ongoingStatus.checked || pendingStatus.checked || endStatus.checked;

                    eventItems.forEach(item => {
                        const eventName = item.querySelector('h2').innerText.toLowerCase();
                        let status = item.querySelector('.status').innerText.toLowerCase();
                        const statArray = status.split(" ");
                        const matchesQuery = eventName.includes(query);
                        
                        console.log(statArray[1]);
                        const matchesStatus = 
                            (pendingStatus.checked && statArray[1] === 'pending') ||
                            (ongoingStatus.checked && statArray[1] === 'ongoing') ||
                            (endStatus.checked && statArray[1] ===  'end') ||
                            (!anyCheckboxChecked); 

                        if (matchesQuery && matchesStatus) {
                            item.style.display = '';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                }

                searchInput.addEventListener('input', updateDisplay);
                ongoingStatus.addEventListener('change', updateDisplay);
                pendingStatus.addEventListener('change', updateDisplay);
                endStatus.addEventListener('change', updateDisplay);

                document.querySelectorAll('.createGame').forEach(button => {
                    button.addEventListener('click', event => {
                        var gameType = event.target.getAttribute('data-game-type');
                        const eventId = event.target.getAttribute('data-event-id');

                        if (gameType.toLowerCase() == 'quiz'){
                            window.location.href = "{{ route('admin.quiz-events', ':eventId') }}".replace(':eventId', eventId);
                        }
                    });
                });

                document.querySelectorAll('.showDetail').forEach(button => {
                    button.addEventListener('click', event => {
                        const eventId = event.target.getAttribute('data-event-id');

                        window.location.href = "{{ route('admin.events.show', ':eventId') }}".replace(':eventId', eventId);
                    });
                });
            });
        </script>
    </x-app-layout>
    @endauth
</body>
</html>
