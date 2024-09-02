<head>
     <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet"
    />
</head>
<body >
    <x-app-layout>
        <div id="container" class="w-auto flex px-20 justify-center relative">
            <div id="container" class="p-10  w-auto flex flex-wrap md:flex-row relative">
                <div class=" flex-1 mr-10">
                    <img
                        class="rounded-lg min-w-[500px] w-full h-auto md:w-auto md:h-auto" 
                        src="{{ asset($user->avatar->image) }}" alt="avatar">
                </div>
                <div class="w-full p-6 flex-1 bg-white rounded-lg shadow-md">
                    <h1 class="font-bold text-3xl mt-6 mb-5 text-gray-800">
                        {{ ucfirst($user->first_name) }} {{ ucfirst($user->last_name) }}
                    </h1>
                    <div class="space-y-4">
                        <p class="w-full mb-1"><b>Email:</b> {{ $user->email }}</p>
                        <p class="w-full mb-1"><b>Student ID:</b> {{ $user->student_id }}</p>
                        <p class="w-full mb-1"><b>Major:</b> {{ $user->majors->name }}</p>
                        <p class="w-full mb-1"><b>Batch:</b> {{ $user->batches->name }}</p>
                        <p class="w-full mb-1"><b>Date of Birth:</b> {{ $user->date_of_birth }}</p>
                        <p class="w-full mb-1"><b>Current GPA:</b> {{ $user->gpa }}</p>
                    </div>
                    <div class="grid grid-cols-1 gap-4 mt-6">
                        <div class="text-center bg-gray-100 p-4 rounded-lg">
                            <h4 class="font-bold text-lg text-gray-700">Academic</h4>
                            <p class="text-gray-600">{{ $academic }}</p>
                        </div>
                        <div class="text-center bg-gray-100 p-4 rounded-lg">
                            <h4 class="font-bold text-lg text-gray-700">Science</h4>
                            <p class="text-gray-600">{{ $science }}</p>
                        </div>
                        <div class="text-center bg-gray-100 p-4 rounded-lg">
                            <h4 class="font-bold text-lg text-gray-700">Art</h4>
                            <p class="text-gray-600">{{ $art }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-100 py-10 rounded-lg w-full">
                    <table class="min-w-full divide-y divide-gray-200 ">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider"> ID
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider"> Event Name
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider"> Category
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
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $attempt->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $attempt->event->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $attempt->event->category->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $attempt->score }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $attempt->start }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $attempt->end }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <button class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700 transition duration-300 ease-in-out">
                                            <a href="{{ route('admin.users.show.details', ['user' => $user ,'attempt' => $attempt]) }}">See Details</a>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </x-app-layout>
    
</body>