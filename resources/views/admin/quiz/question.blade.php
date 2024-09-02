<x-app-layout>
    <div>
        <x-slot name="header">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Event: {{  $event->name }}
            </h2>
        </x-slot>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                       <form action="{{ route('admin.quiz-events.store_questions', $event) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="event_id" value="{{ $event->id }}">
                            <div class="grid grid-cols-5 gap-4">
                                <div class="mb-4 ">
                                    <label for="quiz_name" class="block text-gray-700  text-sm font-bold mb-2">Quiz Name</label>
                                    <input type="text" id="quiz_name" name="quiz_name" placeholder="Quiz Name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                </div>
                                <div class="mb-4">
                                    <label for="duration" class="block text-gray-700 text-sm font-bold mb-2">Duration</label>
                                    <input type="text" id="duration" name="duration" placeholder="In Game Duration" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                </div>
                            </div>
                            <div>
                                <label for="questionNumber" class="block text-gray-700 text-sm font-bold mb-2">Enter number of questions:</label>
                                <input type="number" id="questionNumber" name="questionNumber" min="1" value="1" class="shadow appearance-none border rounded w-16 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                <button type="button" onclick="createQuestions()" class="mb-5 text-">Create Box</button>
                            </div>

                            <div id="questionContainer">
                            </div>

                            <div class="mb-4">
                                <button
                                    class="inline-flex items-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white hover:bg-gray-700">
                                    Create Quiz
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
       function createQuestions() {
            // Clear existing content in the question container
            document.getElementById('questionContainer').innerHTML = '';

            var numQuestions = parseInt(document.getElementById('questionNumber').value);

            for (var i = 1; i <= numQuestions; i++) {
                var questionDiv = document.createElement('div');
                questionDiv.classList.add('question', 'mb-5');
                questionDiv.innerHTML = `
                    <div id="questionContainer">
                        <div class="question mb-5">
                            <h3>Question ${i} | Order: ${i}</h3>
                            <div class="grid grid-cols-3 gap-4">
                                <div class="col-span-2">
                                    <input class="question-input shadow appearance-none border rounded w-full mb-3 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required
                                        name="questions[${i}][text]" id="question${i}"  placeholder="Enter Question ${i}">
                                </div>
                                <div class="dropdown relative">
                                    <button type="button" onclick="openDropdown('dropdown${i}')" class="dropbtn inline-flex items-center rounded-md border border-transparent bg-gray-800 px-4 py-3 text-xs font-semibold uppercase tracking-widest text-white hover:bg-gray-700">
                                        See question bank
                                    </button>
                                    <div id="dropdown${i}" class="dropdown-content absolute px-2 bg-gray-100 rounded-md shadow-md mt-2 w-48 hidden z-10">
                                        <input type="text" id="searchInput${i}" onkeyup="filterDropdown('${i}')" onclick="stopPropagation(event)" class="border-rounded" placeholder="Search...">
                                        <div class="dropdown-options-container" class="h-10 overflow-y-auto py-2" >
                                            @foreach($questions as $question)
                                            <div class="dropdown-option" onclick="selectDropdownOption('${i}', '{{ $question->id }}', '{{ $question->question }}')">{{ $question->question }}</div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                document.getElementById('questionContainer').appendChild(questionDiv);
            }
        }

        function openDropdown(id) {
            var dropdown = document.getElementById(id);
            dropdown.classList.toggle("hidden");
        }

        function stopPropagation(event) {
            event.stopPropagation();
        }


        function selectDropdownOption(dropdownId, optionId, optionText) {
            var inputField = document.getElementById('question' + dropdownId);
            inputField.value = optionText; // Assigning the selected option ID to the input field
            var dropdown = document.getElementById('dropdown' + dropdownId);
            dropdown.classList.add('hidden'); 
        }

        // Close dropdowns when clicking outside
        window.onclick = function(event) {
            if (!event.target.matches('.dropbtn')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (!openDropdown.classList.contains('hidden')) {
                        openDropdown.classList.add('hidden');
                    }
                }
            }
        }

        function filterDropdown(dropdownId) {
            var input, filter, options, option, txtValue;
            input = document.getElementById('searchInput' + dropdownId);
            filter = input.value.toUpperCase();
            options = document.querySelectorAll('#dropdown' + dropdownId + ' .dropdown-option');

            options.forEach(function(option) {
                txtValue = option.textContent || option.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    option.style.display = "";
                } else {
                    option.style.display = "none";
                }
            });
        }


    </script>
</x-app-layout>