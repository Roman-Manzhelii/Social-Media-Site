@extends('layouts.app')

@section('content')
<div class="create-container flex justify-center mt-10">
    <div class="w-full max-w-xl bg-gray-800 rounded-lg shadow-xl overflow-hidden mx-auto">
        <div class="p-5">
            <h5 class="text-white text-lg font-bold mb-4">Profile Information</h5>
            <p class="text-gray-300"><strong>Username:</strong> {{ $user->name }}</p>
            <p class="text-gray-300"><strong>Email:</strong> {{ $user->email }}</p>
            <p class="text-gray-300"><strong>Date of Creation:</strong> {{ $user->created_at->format('M d, Y') }}</p>
            <p class="text-gray-300"><strong>Last Edited:</strong> {{ $user->updated_at->format('M d, Y') }}</p>
            <div class="mt-4 flex justify-center">
                @if($user->image == "user.png")
                    <img class="h-40 w-40 rounded-full border-2 border-gray-700" src="{{ asset('storage/images/default.png') }}" alt="Default Profile Image">
                @else
                    <img class="h-40 w-40 rounded-full border-2 border-gray-700" src="{{ asset('graphic_content/' . $user->image) }}" alt="User Image">
                @endif
            </div>
            <div class="mt-5">
                <a href="{{ route('users.index') }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition duration-200">Back to Users</a>
            </div>
        </div>
    </div>
</div>
@endsection
