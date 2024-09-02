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
                    @foreach ($event->majors as $major)
                        {{ $major->name }}
                    @endforeach
                    @foreach ($event->batches as $batch)
                        {{ $batch->name }}
                    @endforeach
                </p>
                <p><span class="font-bold">Type:</span> {{ $event->type->id }} | {{ $event->type->name }}</p>
                <img src="{{ asset($event->image) }}" alt="preview img" class="max-w-56 max-h-56">
            </div>
        </div>

        <div class="mb-5">
            <h2 class="text-lg font-bold mb-2">Submission Answers</h2>
            <button onclick="autoScore()" class="mb-4 bg-indigo-500 text-white px-4 py-2 rounded-md">Auto Score All</button>
            <button onclick="submitAllForms()" class="mb-4 bg-green-500 text-white px-4 py-2 rounded-md">Submit All</button>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File Link</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Score</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Updated</th>
                        <th scope="col" class="relative px-6 py-3"><span class="sr-only">Edit</span></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($event->submissionAnswers as $submission)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $submission->student->first_name }} {{ $submission->student->last_name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <a href="{{ $submission->file_link }}" target="_blank" class="text-indigo-600 hover:text-indigo-900">
                                    View File
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <form action="{{ route('admin.event.saveScore', $submission->id) }}" method="POST" class="submission-form">
                                    @csrf
                                    <input type="number" name="score" class="score-input border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ $submission->score }}">
                                </form>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $submission->last_updated }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button type="button" onclick="submitForm(this)" class="text-indigo-600 hover:text-indigo-900">Save</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function validateScore(maxScore, inputScore) {
            if (inputScore > maxScore) {
                alert('Score cannot exceed the maximum score of ' + maxScore);
                return false;
            }
            return true;
        }

        function autoScore() {
            let forms = document.querySelectorAll('.submission-form');
            let maxScore = {{ $event->target }};
            forms.forEach(form => {
                let scoreInput = form.querySelector('input[name="score"]');
                if (scoreInput) {
                    scoreInput.value = maxScore;
                } else {
                    console.error('Score input not found in form:', form);
                }
            });
        }

        function submitForm(button) {
            let form = button.closest('tr').querySelector('.submission-form');
            let scoreInput = form.querySelector('input[name="score"]');
            let maxScore = {{ $event->target }};
            
            if (validateScore(maxScore, scoreInput.value)) {
                let formData = new FormData(form);
                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok.');
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        alert('Score updated successfully');
                        location.reload();
                    } else {
                        alert('Failed to update score');
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }

        function submitAllForms() {
            let forms = document.querySelectorAll('.submission-form');
            let completedRequests = 0;

            forms.forEach((form, index) => {
                setTimeout(() => {
                    let scoreInput = form.querySelector('input[name="score"]');
                    let maxScore = {{ $event->target }};

                    if (validateScore(maxScore, scoreInput.value)) {
                        let formData = new FormData(form);
                        fetch(form.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        })
                        .then(response => {
                            if (!response.ok) throw new Error('Network response was not ok.');
                            return response.json();
                        })
                        .then(data => {
                            completedRequests++;
                            if (completedRequests === forms.length) {
                                location.reload();  
                            }
                            if (data.success) {
                                console.log('Score updated successfully for form index:', index);
                            } else {
                                console.error('Failed to update score for form index:', index);
                            }
                        })
                        .catch(error => {
                            completedRequests++;
                            console.error('Error:', error);
                            if (completedRequests === forms.length) {
                                location.reload();  // Reload the page to reflect changes
                            }
                        });
                    }
                }, index * 100);  // Stagger the submission to avoid all forms submitting simultaneously
            });
        }

    </script>
</x-app-layout>