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
                    @php
                        $uniqueBatches = $event->batches->unique('name');
                        $uniqueMajors = $event->majors->unique('name');
                    @endphp

                    @foreach ($uniqueBatches as $batch)
                        {{ $batch->name }}
                    @endforeach
                    @foreach ($uniqueMajors as $major)
                        {{ $major->name }}
                    @endforeach
                </p> 
                <p><span class="font-bold">Type:</span> {{ $event->type->id }} | {{ $event->type->name }}</p>
                <img src="{{ asset($event->image) }}" alt="preview img" class="max-w-56 max-h-56">
            </div>
        </div>
    
        <div class="">
            @if ($attempt)
                <button onclick="alert('There is data being recorded already.');" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700 transition duration-300 ease-in-out">
                    <a href="{{ route('admin.events.edit', $event)}}">Edit</a>
                </button>
            @else
                <button class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700 transition duration-300 ease-in-out">
                    <a href="{{ route('admin.events.edit', $event) }}">Edit</a>
                </button>
            @endif
            <button
                class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-700 transition duration-300 ease-in-out">
                <a href="{{ route('admin.events.delete', $event)}}">Delete</a>
            </button>
            @if ($event->type_id == '1')
                <button class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-700 transition duration-300 ease-in-out">
                    <a href="{{ route('admin.events.showType1', $event) }}">See Result</a>
                </button>
            @elseif ($event->type_id == '2')
                <button class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-700 transition duration-300 ease-in-out">
                    <a href="{{ route('admin.events.showType2', $event) }}">See Result</a>
                </button>
            @endif
        </div>
    </div>

</x-app-layout>