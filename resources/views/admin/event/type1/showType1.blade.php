<!-- resources/views/admin/event/showType1.blade.php -->

<x-app-layout>
    <div class="mt-8 mx-8">
        <div class="mb-5">
            <div class="flex justify-between items-center">
                <h1 class="text-xl font-bold mb-2">{{ $event->name }} Result</h1>
                <form action="#" method="GET" class="mb-4 flex">
                    @csrf
                    <input type="text" id="search" placeholder="Search Event Name..." class="px-4 py-2 border rounded">
                </form>

            </div>
            <div class="bg-gray-100 py-10 rounded-lg w-full">
                
                <table class="min-w-full divide-y divide-gray-200 ">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider"> ID
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider"> User Name
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider"> Score
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Attempt Start</th>
                            <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Attempt End</th>
                            <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                See</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 text-center">
                        @foreach ($quiz_attempts as $attempt)
                            <tr class="student-item">
                                <td class="px-6 py-4 whitespace-nowrap">{{ $attempt->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $attempt->user->first_name }} {{ $attempt->user->last_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $attempt->score }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $attempt->start }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $attempt->end }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button>
                                        <a href="{{ route('admin.events.showType1.showAnswer', ['event' => $event, 'user' => Auth::user()]) }}" class="text-white bg-blue-600 pt-1 pb-2 rounded-md px-2 cursor-pointer transition duration-300 ease-in-out hover:bg-green-800">See Details</a>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search');
            const eventItems = document.querySelectorAll('.student-item');

            searchInput.addEventListener('input', function() {
                const query = this.value.toLowerCase();

                eventItems.forEach(item => {
                    const eventName = item.querySelector('td:nth-child(2)').innerText.toLowerCase();
                    if (eventName.includes(query)) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    </script>
</x-app-layout>
