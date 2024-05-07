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

        {{-- Comments Section --}}
        <div class="mt-6">
            <h2 class="text-xl text-gray-200 font-semibold mb-4">Comments</h2>

            @auth
            {{-- Comment Submission Form --}}
            <form method="POST" action="{{ route('comments.store', $post->id) }}">
                @csrf
                <div class="mb-2">
                    <textarea name="body" rows="3" style="background-color: #333; color: #ccc;" class="w-full p-2 rounded" placeholder="Leave a comment..." required></textarea>
                </div>
                <div class="mb-2">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Comment</button>
                </div>
            </form>
            @endauth

            </br></br>
            @foreach ($post->comments->whereNull('parent_id') as $comment)
            <div class="p-4 rounded-lg shadow-lg my-4 relative" style="background-color: #333; color: #ccc;" id="comment-{{ $comment->id }}">
                <div class="mb-2">
                    <strong>{{ $comment->user->name }}</strong> - <span class="text-gray-400">{{ $comment->updated_at->diffForHumans() }}</span>
                </div>

                <div id="edit-form-{{ $comment->id }}" class="edit-comment-form hidden" >
                    <form method="POST" action="{{ route('comments.update', $comment->id) }}">
                        @csrf
                        @method('PUT')
                        <textarea name="body" rows="8" class="w-full p-3 rounded border" style="background-color: #333;">{{ $comment->description }}</textarea>
                        <button type="submit" class="mt-2 inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-green-500 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-green">Update</button>
                        <button type="button" onclick="cancelEdit({{ $comment->id }})" class="mt-2 inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">Cancel</button>
                    </form>
                </div>

                <div class="comment-body break-words" id="comment-text-{{ $comment->id }}">
                    @if($comment->is_deleted)
                        <div class="deleted-comment">
                            deleted comment
                        </div>
                    @else
                        <div>
                            {{ $comment->body }}
                        </div>
                    @endif
                
                </div>

                @if (auth()->check() && auth()->user()->id == $comment->user_id)
                    <div class="absolute top-0 right-0 p-2 ">
                        <button class="ellipsis-btn" onclick="toggleMenu({{ $comment->id }})">︙</button>
                        <div class="menu-hidden" id="menu-{{ $comment->id }}">
                            <button onclick="editComment({{ $comment->id }})" class="text-sm text-blue-500">Edit</button>
                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this comment?')" class="text-sm text-red-500">Delete</button>
                            </form>                            
                        </div>
                    </div>
                @endif

                {{-- Show replies button --}}
                <div class="flex justify-between items-center mt-2">
                    @if($comment->replies->count() > 0)
                    <button onclick="toggleReplies({{ $comment->id }})" class="text-sm text-blue-500 hover:text-blue-800 focus:outline-none focus:ring-0">View {{ $comment->replies->count() }} replies</button>
                    @endif
                
                    @if (auth()->check() && auth()->user()->id != $comment->user_id)
                        <button class="reply-btn mt-2 text-sm text-white bg-blue-500 hover:bg-blue-600 font-medium py-2 px-4 rounded transition duration-300" onclick="showReplyForm(event, {{ $comment->id }})">Reply</button>
                    @endif
                </div>

                <!-- Форма для відповіді (прихована за замовчуванням) -->
                <div id="reply-form-{{ $comment->id }}" class="hidden mt-2">
                    <form method="POST" action="{{ route('comments.store', $post->id) }}">
                        @csrf
                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                        <textarea name="body" rows="2" class="w-full p-3 rounded border " style="background-color: #333;" placeholder="Write a reply..."></textarea>
                        <button type="submit" class="text-sm bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded mt-1">Submit Reply</button>
                    </form>
                </div>
            
                <div id="replies-{{ $comment->id }}" class="replies-container hidden ml-4 mt-2">
                    @foreach ($comment->replies as $reply)
                    <div class="border reply p-3 rounded my-2" style="background-color: #333;">
                        <strong>{{ $reply->user->name }} </strong> - <span class="text-gray-400">{{ $reply->updated_at->diffForHumans() }}</span>
                        <p>{{ $reply->description }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <script>
        function editComment(commentId) {
            const commentDiv = document.getElementById(`comment-${commentId}`);
            commentDiv.querySelector('.comment-body').classList.add('hidden');
            commentDiv.querySelector('.edit-comment-form').classList.remove('hidden');
        }
    
        function cancelEdit(commentId) {
            const commentDiv = document.getElementById(`comment-${commentId}`);
            commentDiv.querySelector('.comment-body').classList.remove('hidden');
            commentDiv.querySelector('.edit-comment-form').classList.add('hidden');
        }
    
        function showReplyForm(event, commentId) {
        event.preventDefault();
        var form = document.getElementById('reply-form-' + commentId);
            if(form) {
                form.classList.toggle('hidden');
            }
        }
        
        function toggleReplies(commentId) {
            var repliesDiv = document.getElementById('replies-' + commentId);
            repliesDiv.classList.toggle('hidden');
        }
    
        function toggleMenu(commentId) {
        var menu = document.getElementById('menu-' + commentId);
            if (menu.classList.contains('menu-hidden')) {
                menu.classList.remove('menu-hidden');
                menu.classList.add('menu-visible');
            } else {
                menu.classList.remove('menu-visible');
                menu.classList.add('menu-hidden');
            }
        }
    
    </script>

    @endsection