<head>
     <link href="{{ asset('storage/css/MultiSelect.css')}}" rel="stylesheet" type="text/css">
</head>

<body>
    
    <x-app-layout>
        <div class="max-w-7xl mx-auto pt-7">
            <form action="{{ route('admin.events.store') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" enctype="multipart/form-data"">
                @csrf
                <div class="grid grid-cols-4 gap-4">
                    <div class="mb-4 custom-width-1">
                        <label for="category" class="block text-gray-700 text-sm font-bold mb-2">Event Category</label>
                        <select id="category" name="category" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4 custom-width-2">
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Event Name</label>
                        <input type="text" id="name" name="name" placeholder="Event name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4 custom-width-3">
                        <label for="point" class="block text-gray-700 text-sm font-bold mb-2">Point</label>
                        <input type="text" id="point" name="point" placeholder="Point" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label for="target" class="block text-gray-700 text-sm font-bold mb-2">Target Progress</label>
                        <input type="text" id="target" name="target" placeholder="Target Progress" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></input>
                    </div>
                    <div class="mb-4">
                        <label for="max_participants" class="block text-gray-700 text-sm font-bold mb-2">Max Participants</label>
                        <input type="text" id="max_participants" name="max_participants" placeholder="Max Participants" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></input>
                    </div>
                    <div class="mb-4">
                        <label for="start" class="block text-gray-700 text-sm font-bold mb-2">Start Date</label>
                        <input type="datetime-local" id="start" name="start_date" placeholder="Start Date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></input>
                    </div>
                    <div class="mb-4">
                        <label for="end" class="block text-gray-700 text-sm font-bold mb-2">End Date</label>
                        <input type="datetime-local" id="end" name="end_date" placeholder="End Date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></input>
                    </div>
                    <div class="mb-4">
                        <label for="type" class="block text-gray-700 text-sm font-bold mb-2">Type</label>
                        <select id="type" name="type" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @foreach ($types as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="major" class="block text-gray-700 text-sm font-bold mb-2">Major</label>
                        <select id="major" name="requirements[major][]" multiple data-multi-select data-placeholder="Choose Major" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @foreach ($majors as $major)
                                <option value="{{ $major->id }}">{{ $major->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="batch" class="block text-gray-700 text-sm font-bold mb-2">Batch</label>
                        <select id="batch" name="requirements[batch][]" multiple data-multi-select data-placeholder="Choose Batch" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @foreach ($batches as $batch)
                                <option value="{{ $batch->id }}">{{ $batch->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="cat_req" class="block text-gray-700 text-sm font-bold mb-2">Category ID</label>
                        <select id="cat_req" name="requirements[cat_req]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->id }}/{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="cat_score" class="block text-gray-700 text-sm font-bold mb-2">Req Point</label>
                        <input type="text" id="cat_score" name="cat_score" placeholder="Min Point" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></input>
                    </div>
                </div>
    
                <div class="mb-4">
                    <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                    <textarea id="description" name="description" rows="4" minlength="50" placeholder="Enter the description here" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                </div>
    
                    <div class="mb-4 w-1/4">
                    <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Event Image</label>
                        <img id="preview" src="{{ asset('image-preview.png') }}" alt="Preview" class="max-w-28 max-h-28">
                        <input type="file" id="image" name="image" placeholder="Event Image"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></input>
                        <p class="text-gray-500 text-xs italic">Max Size 5 MB</p>
                </div>
    
                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Submit</button>
                </div>
            
            </form>
        </form>
    
        <script>
            function displayImage(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('preview').src = e.target.result;
                        document.getElementById('preview').style.display = 'block';
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
    
            // Call the displayImage function when the file input changes
            document.getElementById('image').addEventListener('change', function() {
                displayImage(this);
            });
    
            // toggle dropdown visibility function
            function toggleDropdown() {
                const dropdown = document.getElementById('requirements');
                dropdown.classList.toggle('hidden');
            }
    
            // Event listener for clicking outside the dropdown to close it
            window.addEventListener('click', function(event) {
                if (!event.target.closest('.dropdown') && !event.target.matches('.dropdown button')) {
                    const dropdowns = document.querySelectorAll('.dropdown-content');
                    dropdowns.forEach(dropdown => {
                        if (!dropdown.classList.contains('hidden')) {
                            dropdown.classList.add('hidden');
                        }
                    });
                }
            });
    
            // Event listener for checkbox changes
            document.querySelectorAll('.dropdown-content input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const selectedItems = document.querySelector('.selected-items');
                    const text = this.nextSibling.textContent.trim();
                    const value = this.value;
    
                    if (this.checked) {
                        // Create a new div for the selected item
                        const selectedItem = document.createElement('div');
                        selectedItem.setAttribute('data-value', value);
                        selectedItem.textContent = text;
                        selectedItems.appendChild(selectedItem); 
                    } else {
                        // Remove the selected item if checkbox is unchecked
                        const selectedItemId = `div[data-value="${value}"]`;
                        const existingItem = selectedItems.querySelector(selectedItemId);
                        if (existingItem) {
                            existingItem.remove();
                        }
                    }
                });
            });
    
        </script>
    
    </x-app-layout>
    
    <script src="{{ asset('storage/js/MultiSelect.js') }}"></script>
</body>

