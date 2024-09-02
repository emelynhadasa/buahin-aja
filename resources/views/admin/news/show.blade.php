<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css') <!-- Include your compiled CSS -->
</head>
<body>
    @auth
    <x-app-layout>
        <div class="container mx-auto py-6">
            <h1 class="text-2xl font-bold mb-4">{{ $news->title }}</h1>
            <p><strong>Type:</strong> {{ $news->type }}</p>
            <p><strong>Description:</strong> {{ $news->description }}</p>
            <p><strong>Publisher:</strong> {{ $news->publisher }}</p>
            <p><strong>Publish Date:</strong> {{ $news->publish_date }}</p>
            <p><strong>Order Number:</strong> {{ $news->order_number }}</p>
            <p><strong>Status:</strong> {{ $news->status }}</p>
            @if($news->image)
                <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" class="max-w-full mt-4">
            @endif
        </div>
    </x-app-layout>
    @endauth
</body>
</html>
