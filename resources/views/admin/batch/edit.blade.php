<x-app-layout>
    <div class="max-w-3xl mx-auto pt-7">
        <form action="{{ route('admin.batches.update', $batch) }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                    <input value="{{ $batch->name }}" type="text" id="name" name="name"
                        placeholder="Batch name"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <button type="submit"
                        class="mx-auto bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline my-5">Submit</button>
                </div>
                
        </form>
    </div>
</x-app-layout>