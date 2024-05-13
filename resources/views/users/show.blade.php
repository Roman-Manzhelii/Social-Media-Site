@extends('layouts.app')

@section('content')
<div class="create-container flex justify-center mt-10 overflow-x-auto">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Profile Information</h5>
            <p><strong>Username:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Date of Creation:</strong> {{auth()->user()->created_at}}</p>
            <p><strong>Last Edited:</strong> {{auth()->user()->updated_at}}</p>
            @if($user->image == "user.png")
            <img class="profile_image" src="{{ asset('storage/images/default.png') }}" alt="">
        @else
            <img src="{{ asset('graphic_content/' . auth()->user()->image) }}" alt="Post Image">
        @endif
            <!-- Add more fields as needed -->
            <a href="{{ route('users.index') }}" class="btn btn-primary">Back to Users</a>
        </div>
    </div>
</div>
@endsection
