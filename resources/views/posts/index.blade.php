@extends('layouts.app')

@section('content')
<div class="container max-w-4xl mx-auto py-8">
    @if ($posts->isNotEmpty())
    <div>
        @foreach ($posts as $post)
            <div class="media-container max-w-lg text-white rounded-lg overflow-hidden">
                @php
                    $fileExtension = strtolower(pathinfo($post->path, PATHINFO_EXTENSION));
                @endphp
                
                <div class="media">
                    @if(in_array($fileExtension, ['jpeg', 'png', 'jpg', 'gif', 'svg']))
                        <img src="{{ asset('graphic_content/' . $post->path) }}" alt="Post Image" class="w-full">
                    @elseif(in_array($fileExtension, ['mp4', 'mov', 'ogg', 'qt']))
                        <video controls class="w-full">
                            <source src="{{ asset('graphic_content/' . $post->path) }}" type="video/{{ $fileExtension }}">
                            Your browser does not support the video tag.
                        </video>
                    @else
                        <p>Unsupported file format</p>
                    @endif
                </div>
                
                <div class="px-4 py-2">
                    <strong class="font-bold">{{ $post->user->name }} <span class="text-gray-400 text-sm">{{ $post->created_at->diffForHumans() }}</span></strong>
                    <p class="my-2">{{ Illuminate\Support\Str::limit($post->description, 100, '...') }}</p>
                    <a href="{{ route('posts.show', $post->id) }}" class="comments-link text-blue-400">View all comments</a>
                </div>
            </div>            
        @endforeach
    </div>    
    @else
        <div class="text-center">
            <p class="text-gray-600">No posts available.</p>
        </div>
    @endif
</div>
@endsection
