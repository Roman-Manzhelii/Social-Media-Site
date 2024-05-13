<link rel="stylesheet" href="{{ asset('css/style.css') }}">

<x-app-layout class="bg-black">
    <x-slot name="header">
        <div class="create-container flex justify-center mt-10">
            <div class="w-full max-w-xl bg-gray-800 rounded-lg shadow-xl overflow-hidden mx-auto">

                <div class="text-center p-5">
                    <p class="text-gray-300 mb-4">Change Profile Picture:</p>
                    <form action="/upload-image" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input id="image_input_box" type="file" name="image">
                        <button id="image_upload_btn" type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition duration-200">Upload Image</button>
                    </form>
                </div>

                <div class="mt-4 flex justify-center">
                    @if(auth()->user()->image == "user.png")
                        <img class="h-40 w-40 rounded-full border-2 border-gray-700" src="{{ asset('storage/images/default.png') }}" alt="Default Profile Image">
                    @else
                        <img class="h-40 w-40 rounded-full border-2 border-gray-700" src="{{ asset('graphic_content/' .  auth()->user()->image) }}" alt="User Image">
                    @endif
                </div>

                <div class="p-5">
                    <h5 class="text-white text-lg font-bold mb-4">Profile Information</h5>
                    <p class="text-gray-300"><strong>Username:</strong> {{ auth()->user()->name }}</p>
                    <p class="text-gray-300"><strong>Email:</strong> {{ auth()->user()->email }}</p>
                    <p class="text-gray-300"><strong>Date of Creation:</strong> {{ auth()->user()->created_at->format('M d, Y') }}</p>
                    <p class="text-gray-300"><strong>Last Edited:</strong> {{ auth()->user()->updated_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>
