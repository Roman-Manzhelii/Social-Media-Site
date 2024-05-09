@extends('layouts.app')

@section('content')

<div class="container mx-auto px-4 py-8">
    @if ($posts->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($posts as $post)
                <div class="bg-white rounded-lg shadow-lg p-4">
                    <div class="mb-2">
                        <strong class="text-lg">{{ $post->user->name }}</strong>
                        <span class="text-sm text-gray-600">Posted on {{ $post->created_at->format('M d, Y') }}</span>
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
                    </div>
                    
                    <div class="text-gray-800 mb-4">{{ $post->content }}</div>
                    <div>
                        <a href="{{ route('posts.show', $post->id) }}" class="text-blue-500 hover:text-blue-700">Read more</a>
                        @auth
                            <a href="#" class="ml-2 text-gray-500 hover:text-gray-700">Comment</a>
                        @endauth
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-6">
            {{ $posts->links() }}
        </div>
    @else
        <div class="text-center">
            <p class="text-gray-600">No posts available.</p>
        </div>
    @endif

    <!-- Кнопка для створення нового поста -->
        <a href="{{ route('posts.create') }}" class="btn btn-primary">Create Post</a>

</div>
@endsection
