@extends('layouts.app')

@section('content')
<div class="create-container flex justify-center">
    <div class="create">
        <h1>Edit Post</h1>
        <form method="POST" action="{{ route('posts.update', $post->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required>{{ $post->description }}</textarea>
            </div>
            <div class="mb-3">
                <label for="graphicContent" class="form-label">Upload Image/Video</label>
                <input type="file" class="form-control" id="graphicContent" name="graphicContent" accept="image/*,video/*">
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
            <button type="submit" class="btn btn-primary">Update Post</button>
        </form>
    </div>
</div>
@endsection
