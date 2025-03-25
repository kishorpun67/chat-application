<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Todo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
    <div class="flex items-center justify-center bg-gray-100">

        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-4xl">
            <h1 class="text-2xl font-bold mb-6 text-gray-800">Create Post</h1>

            <form method="POST" action="{{ route('create.todo') }}" class="space-y-4">
            @csrf

            <!-- title Input -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <input
                type="text"
                id="title"
                name="title"
                value="{{ old('title') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('title') border-red-500 @enderror"
                >
                @error('title')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Input -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">description</label>
                <textarea 
                name="description" id="" 
                class="mt-1 block w-full rounded-md
                 border-gray-300 
                 shadow-sm focus:border-blue-500 
                 focus:ring-blue-500 @error('title')
                  border-red-500 @enderror"

                ></textarea>
                @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

        

            <!-- Submit Button -->
            <button
                type="submit"
                class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition-colors"
            >
                Create Post
            </button>
            </form>

            <table class="min-w-full border mt-10 border-gray-300 rounded-lg overflow-hidden shadow-lg">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="px-4 py-2 text-left">ID</th>
                        <th class="px-4 py-2 text-left">Title</th>
                        <th class="px-4 py-2 text-left">Message</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-300">
                    @forelse ($todos as $todo)
                        <tr>
                            <td class="px-4 py-2">{{$todo->id}}</td>
                            <td class="px-4 py-2">{{$todo->title}}</td>
                            <td class="px-4 py-2">{{$todo->description}}</td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
