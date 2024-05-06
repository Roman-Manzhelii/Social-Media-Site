@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Post</h1>
    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="graphicContent" class="form-label">Upload Image/Video</label>
            <input type="file" class="form-control" id="graphicContent" name="graphicContent" accept="image/*,video/*" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
