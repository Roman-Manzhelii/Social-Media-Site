@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg p-4">
        <div class="mb-4">
            <h2 class="text-xl font-bold">{{ $post->title }}</h2>
            <p class="text-sm text-gray-600">Posted by {{ $post->user->name }} on {{ $post->created_at->format('M d, Y') }}</p>
        </div>
        <div class="mb-4">
            @php
                $fileExtension = pathinfo($post->path, PATHINFO_EXTENSION);
            @endphp
        
            @if(in_array($fileExtension, ['jpeg', 'png', 'jpg', 'gif', 'svg']))
                <img src="{{ asset('graphic_content/' . $post->path) }}" alt="Post Image" class="rounded-lg w-full h-auto">
            @elseif(in_array($fileExtension, ['mp4', 'mov', 'ogg', 'qt']))
                <video controls class="rounded-lg w-full h-auto">
                    <source src="{{ asset('graphic_content/' . $post->path) }}" type="video/{{ $fileExtension }}">
                    Your browser does not support the video tag.
                </video>
            @else
                <p>Unsupported file format</p>
            @endif
            <div class="text-gray-800 mb-4">
                {{ $post->content }}
            </div>
            @if (auth()->id() == $post->user_id)
                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary">Edit</a>
                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            @endif
        </div>
    </div>
    @endsection