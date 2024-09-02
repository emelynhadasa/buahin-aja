<x-app-layout>
    <div class="p-16">
        <div class="pb-10 text-center ">
            <h1 class="font-bold text-3xl">Recent Articles</h1>
        </div>
        <div class="grid grid-cols-4 gap-4 border-rounded">
            @foreach ($news as $item)
                @if ($item->status == 'active')
                    <section class="item-item">
                            <div class="bg-white rounded-sm p-2 hover:-translate-y-1 transition duration-300">
                                <a href="{{ route('user.news.show', $item) }}" class="news-item">
                                    <img src="{{ asset($item->image) }}" alt="Preview Image" class="w-auto h-52 mb-2 rounded-sm">
                                </a>
                                <h2 class="text-3xl text-black font-bold mb-2">{{ $item->title }} </h2>
                                <p class="text-gray-600">{{ Str::limit($item->description, 200) }}</p>
                                <p class="text-black mt-2">{{ $item->type }}</p>
                                <div class="flex mb-3 justify-between">
                                    <div class="flex1">
                                        <p>Publisher: {{ $item->publisher }}</p>
                                    </div>
                                    <div>
                                        <p>{{ $item->publish_date }}</p>
                                    </div>
                            </div>
                        </div>
                    </section>
                @endif
            @endforeach
       </div>

    </div>
</x-app-layout>