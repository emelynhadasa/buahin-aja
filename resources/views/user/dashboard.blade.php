<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Gradient Container -->
            <div class="relative bg-gradient-to-br from-cyan-600 to-gray-800 text-white rounded-2xl p-8 flex flex-col items-center justify-center" style="height: 33vh;">
                <h1 class="text-3xl font-bold mb-2 text-center">Welcome back, {{ $user->first_name }}!</h1>
                <p class="text-lg text-center">Always stay updated in PULSE portal.</p>
            </div>
        </div>
        <div class="p-10">
            <!-- Latest Events Section -->
            <section class="w-full p-6 mb-6 bg-white rounded-lg shadow-md relative">
                <h3 class="text-2xl mb-4">Latest Events</h3>
                <div class="flex overflow-x-hidden mx-5 space-x-4" id="events-container">
                    @foreach ($events as $event)
                        <div class="event-item flex-shrink-0 bg-white rounded-lg shadow-md p-2">
                            <button onclick="openModal('modal-event-{{ $event->id }}')">
                                <img src="{{ asset($event->image) }}" alt="Event Image" class="w-40 h-24 object-cover rounded-lg">
                            </button>
                        </div>
                    @endforeach
                </div>
                <button class="absolute left-0 top-1/2 transform -translate-y-1/2 p-3 rounded-full shadow-lg hover:bg-gray-400" id="scroll-left-events">
                    &lt;
                </button>
                <button class="absolute right-0 top-1/2 transform -translate-y-1/2 p-3 rounded-full shadow-lg hover:bg-gray-400" id="scroll-right-events">
                    &gt;
                </button>
            </section>

            <!-- Latest News and Support Contact Section -->
            <div class="flex space-x-4">
                <!-- Latest News -->
                <section class="w-1/2 p-6 bg-white rounded-lg shadow-md relative">
                    <h3 class="text-2xl mb-4">Latest News</h3>
                    <div class="flex overflow-x-hidden mx-5 space-x-4" id="news-container">
                        @foreach ($news as $item)
                            @if ($item->status == 'active')
                                <div class="news-item flex-shrink-0 bg-white rounded-lg shadow-md p-2">
                                    <button onclick="openModal('modal-news-{{ $item->id }}')">
                                        <img src="{{ asset($item->image) }}" alt="News Image" class="w-40 h-24 object-cover rounded-lg">
                                    </button>
                                    <div class="mt-2 flex flex-col">
                                        <div class="flex items-center justify-between">
                                            <p class="font-bold text-lg mr-2">{{ $item->title }}</p>
                                            <div class="flex items-center text-gray-600">
                                                <!-- Calendar Icon -->
                                                <i class="fa-regular fa-calendar w-5 h-5 mr-0.5"></i>
                                                <!-- Date -->
                                                <span class="text-sm">{{ $item->created_at->format('d M, Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <button class="absolute left-0 top-1/2 transform -translate-y-1/2 p-3 rounded-full shadow-lg hover:bg-gray-400" id="scroll-left-news">
                        &lt;
                    </button>
                    <button class="absolute right-0 top-1/2 transform -translate-y-1/2 p-3 rounded-full shadow-lg hover:bg-gray-400" id="scroll-right-news">
                        &gt;
                    </button>
                </section>

                <!-- Support Contact Section -->
                <section class="w-1/2 p-6 bg-gray-100 rounded-lg shadow-md">
                    <h3 class="text-2xl mb-4">Support Contact</h3>
                    <div class="p-4">
                        <p class="text-lg font-semibold">PULSE Support Team</p>
                        <p class="text-sm mt-2">For any inquiries, please contact us at:</p>
                        <ul class="mt-2">
                            <li>Email: support@pulse.com</li>
                            <li>Phone: +123-456-7890</li>
                        </ul>
                    </div>
                </section>
            </div>
        </div>

        <!-- Modal For Latest News -->
        @foreach ($news as $item)
            <div id="modal-news-{{ $item->id }}" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center hidden transition-opacity duration-300" onclick="closeModal('modal-news-{{ $item->id }}')">
                <section class="overflow-y-auto rounded-lg shadow-2xl w-3/4 md:w-1/2 h-3/4 md:h-2/5 bg-white relative p-6" onclick="event.stopPropagation()">
                    <button onclick="closeModal('modal-news-{{ $item->id }}')" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                        &times;
                    </button>
                    <div class="flex flex-col md:flex-row">
                        <img alt="news" src="{{ asset($item->image) }}" class="object-cover w-full md:w-1/3 h-32 md:h-auto rounded-lg"/>
                        <div class="md:ml-4 mt-4 md:mt-0">
                            <h2 class="text-2xl font-bold">{{ $item->title }}</h2>
                            <p class="text-sm font-semibold mt-2">{{ $item->publisher }} | {{ $item->publish_date }}</p>
                            <p class="mt-4 text-gray-700">{{ $item->description }}</p>
                        </div>
                    </div>
                </section>
            </div>
        @endforeach

        <!-- Modal for Latest Events -->
        @foreach ($events as $event)
            <div id="modal-event-{{ $event->id }}" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center hidden transition-opacity duration-300" onclick="closeModal('modal-event-{{ $event->id }}')">
                <section class="overflow-y-auto rounded-lg shadow-2xl w-3/4 md:w-1/2 h-3/4 md:h-2/5 bg-white relative p-6" onclick="event.stopPropagation()">
                    <button onclick="closeModal('modal-event-{{ $event->id }}')" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                        &times;
                    </button>
                    <div class="flex flex-col md:flex-row">
                        <img alt="event" src="{{ asset($event->image) }}" class="object-cover w-full md:w-1/3 h-32 md:h-auto rounded-lg"/>
                        <div class="md:ml-4 mt-4 md:mt-0">
                            <h2 class="text-2xl font-bold">{{ $event->name }}</h2>
                            <p class="text-sm font-semibold mt-2">Ended at {{ $event->end }}</p>
                            <p class="mt-4 text-gray-700">{{ $event->description }}</p>
                        </div>
                    </div>
                </section>
            </div>
        @endforeach

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('scroll-left-events').onclick = function() {
                    document.getElementById('events-container').scrollBy({
                        left: -200,
                        behavior: 'smooth'
                    });
                };

                document.getElementById('scroll-right-events').onclick = function() {
                    document.getElementById('events-container').scrollBy({
                        left: 200,
                        behavior: 'smooth'
                    });
                };

                document.getElementById('scroll-left-news').onclick = function() {
                    document.getElementById('news-container').scrollBy({
                        left: -200,
                        behavior: 'smooth'
                    });
                };

                document.getElementById('scroll-right-news').onclick = function() {
                    document.getElementById('news-container').scrollBy({
                        left: 200,
                        behavior: 'smooth'
                    });
                };
            });

            function openModal(modalId) {
                document.getElementById(modalId).classList.remove('hidden');
            }

            function closeModal(modalId) {
                document.getElementById(modalId).classList.add('hidden');
            }
        </script>
        @if (session()->has('success'))
            <script>
                alert("{{ session('success') }}");
            </script>
        @endif
    </div>
</x-app-layout>
