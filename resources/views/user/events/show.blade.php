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
    </div>

</x-app-layout>