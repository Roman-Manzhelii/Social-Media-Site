<link rel="stylesheet" href="{{ asset('css/style.css') }}">

<x-app-layout>
    <x-slot name="header">

        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>

        @if(auth()->user()->image == "user.png")
            <img class="profile_image" src="{{ asset('storage/images/default.png') }}" alt="">
        @else
            <img class="profile_image" src="{{ asset('storage/' . auth()->user()->image) }}" alt="">
        @endif

        <div>
            <p>Change Profile Picture:</p>
            <form action="/upload-image" method="POST" enctype="multipart/form-data">
                @csrf
                <input id = "image_input_box" type="file" name="image">
                <button id = "image_upload_btn" type="submit">Upload Image</button>
            </form>
        </div>

        <ul>
            <li>Username: {{ auth()->user()->name }}</li>
            <li>Email: {{ auth()->user()->email }}</li>
            <li>Date of Creation: {{auth()->user()->created_at}}</li>
            <li>Last Edited: {{auth()->user()->updated_at}}</li>
        </ul>

        <br>
        
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
