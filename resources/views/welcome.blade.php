<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>PULSE</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        @vite('resources/css/app.css')
    </head>
    <body class="bg-gradient-to-br from-cyan-600 to-gray-800 text-white p-4">
       <div class="flex justify-between items-center p-6">
            <div class="text-3xl font-bold">PULSE</div>
            <nav>
                <a href="#" class="text-lg">
                    @if (Route::has('login'))
                    <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                        @auth
                            <a href="{{ url('/user/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>
                        @endauth
                    </div>
                    @endif
                </a>
            </nav>
        </div>

        <div class="flex justify-between items-center p-6">
            <div class="flex">
                <section class="w-1/2 p-12">
                    <h2 class="text-4xl font-bold mb-4">President University Learning System Engagement</h2>
                    <p class="mb-6">PULSE is a dynamic and interactive app designed to enhance the student's learning activity at President University. 
                        This comprehensive platform integrates various aspects of campus life, providing students with easy access to essential 
                        information and engaging activities.</p>
                </section>
                <section class="w-1/2 h-full flex justify-center items-center">
                    <img src="{{ asset('image-preview.png') }}" alt="Icon" class="w-1/2">
                </section>
            </div>
        </div>
        <div class="px-5">
            <section class="">
                <h3 class="text-2xl mb-4 px-12">Share your experience</h3>
                <div class="flex justify-left pl-11">
                    <a href="" class="bg-white rounded-full w-10 h-10 flex items-center justify-center mx-3">
                        <img src="{{ asset('facebook.png') }}" alt="Facebook" class="w-6">
                    </a>
                    <a href="" class="bg-white rounded-full w-10 h-10 flex items-center justify-center mx-3">
                        <img src="{{ asset('instagram.png') }}" alt="Instagram" class="w-6 mx-3">
                    </a>
                    <a href="" class="bg-white rounded-full w-10 h-10 flex items-center justify-center mx-3">
                        <img src="{{ asset('linkedin.png') }}" alt="Linkedin" class="w-6 mx-3">
                    </a>
                </div>
            </section>
        </div>

        <div class="p-10">
            
           <section class="p-6 relative">
                <h3 class="text-2xl mb-4">News</h3>
                <div class="flex overflow-x-hidden mx-5 space-x-4" id="news-container">
                    @foreach ($news as $item)
                        @if ($item->status == 'active')
                            <div class="news-item flex-shrink-0">
                                <button onclick="openModal('modal{{ $item->id }}')">
                                    <img src="{{ asset($item->image) }}" alt="News Image" class="w-40">
                                </button>
                                <p class="mt-2 text-center">{{ $item->title }}</p>
                            </div>
                        @endif
                    @endforeach
                </div>
                <button class="absolute left-0 top-1/2 transform -translate-y-1/2 p-3 rounded-full shadow-lg hover:bg-gray-400" id="scroll-left">
                    &lt;
                </button>
                <button class="absolute right-0 top-1/2 transform -translate-y-1/2 p-3 rounded-full shadow-lg hover:bg-gray-400" id="scroll-right">
                    &gt;
                </button>
            </section>
        </div>



        <!-- Modal Structure -->
         @foreach ($news as $item)
            <div id="modal{{ $item->id }}" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center hidden" onclick="closeModal('modal{{ $item->id }}')">
                <section class="overflow-y-auto rounded-lg shadow-2xl w-2/3 h-2/3 md:grid md:grid-cols-3 bg-white" onclick="event.stopPropagation()">
                    <img alt="news" src="{{ asset($item->image) }}" class="object-cover md:h-full"/>
                    <div class="p-4 text-center sm:p-6 md:col-span-2 lg:p-8 text-black">
                        <h2 class="font-black uppercase">
                            <span class="text-4xl font-black sm:text-5xl lg:text-6xl">{{ $item->title }}</span>
                        </h2>
                        <p class="text-sm font-semibold uppercase tracking-widest mt-4">{{ $item->publisher }} | {{ $item->publish_date }}</p>
                        <p class="mt-8 text-xs text-left font-medium uppercase text-gray-400 whitespace-pre-wrap">{{ $item->description }}</p>
                    </div>
                </section>
            </div>
         @endforeach

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                
                document.getElementById('scroll-left').onclick = function() {
                    document.getElementById('news-container').scrollBy({
                        left: -200,
                        behavior: 'smooth'
                    });
                };
    
                document.getElementById('scroll-right').onclick = function() {
                    document.getElementById('news-container').scrollBy({
                        left: 200,
                        behavior: 'smooth'
                    });
                };
    
                var modal = document.getElementById('modal');

            });
            function openModal(modalId) {
                document.getElementById(modalId).classList.remove('hidden');
            }

            function closeModal(modalId) {
                document.getElementById(modalId).classList.add('hidden');
            }

        </script>
    </body>
</html>
