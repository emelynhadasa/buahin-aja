@php
    use Carbon\Carbon;
    $date = Carbon::parse($news->created_at);
    $now = Carbon::now('Asia/Bangkok');
    $hours_passed = $date->diffInHours($now);
    $time_passed = $hours_passed . ' hours';

    if($hours_passed >= 24){
        $days_passed = $date->diffInDays($now);
        $time_passed = $days_passed . ' days';
    }
@endphp

<body>
    <x-app-layout>
        <div class="flex flex-col p-10 w-1/2 mx-auto">
            <h1 class="text-8xl font-bold text-left">{{ $news->title }}</h1>
            <div class="flex-grow"></div> 
            <p class="mt-auto py-6 text-xl">{{ $news->publisher }} ~ {{ $time_passed }} ago</p>
            <img src="{{ asset($news->image) }}" alt="News Image" class="w-full mb-10">
            <p class="text-2xl whitespace-pre-wrap text-justify">{{ $news->description }}</p>
        </div>
    </x-app-layout>
    
</body>