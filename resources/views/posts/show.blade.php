@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Media Section -->
    <div class="media-section">
            @php
                $fileExtension = strtolower(pathinfo($post->path, PATHINFO_EXTENSION));
            @endphp
            @if(in_array($fileExtension, ['jpeg', 'png', 'jpg', 'gif', 'svg']))
                <img src="{{ asset('graphic_content/' . $post->path) }}" alt="Post Image">
            @elseif(in_array($fileExtension, ['mp4', 'mov', 'ogg', 'qt']))
                <video controls>
                    <source src="{{ asset('graphic_content/' . $post->path) }}" type="video/{{ $fileExtension }}">
                </video>
            @else
                <p class="text-center">Unsupported file format</p>
            @endif
        <div class="description">
            <p>Posted by {{ $post->user->name }} on {{ $post->created_at->format('M d, Y') }}</p>
            <br/>
            <p>{{ $post->description }}</p>
        </div>
    </div>


    <!-- Comments Section -->
    <div class="comments-section">
        <div class="scrollable-comments">
            @foreach ($post->comments->whereNull('parent_id') as $comment)
                <div class="comment" id="comment-{{ $comment->id }}">
                    <div class="comment-body" id="comment-body-{{ $comment->id }}">
                        <strong>{{ $comment->user->name}}</strong>
                        @if($comment->is_deleted)
                            <span class="deleted-comment">
                                deleted comment
                            </span>
                        @else
                            <span>
                                {{ $comment->content }}
                            </span>
                        @endif
                        <div class="comment-actions">
                            <span class="comment-time">{{ $comment->created_at->diffForHumans() }}</span>
                            <button onclick="showReplyForm(event, {{ $comment->id }})" class="hover:text-blue-500">Reply</button>
                            @if (auth()->check() && auth()->user()->id == $comment->user_id)
                            <div>
                                <button class="hover:text-blue-500" onclick="toggleMenu({{ $comment->id }})">...</button>
                                <div class="hidden" id="menu-{{ $comment->id }}">
                                    <button onclick="editComment({{ $comment->id }})" class="text-blue-500">Edit</button>
                                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500" onclick="return confirm('Are you sure you want to delete this comment?');" >Delete</button>
                                    </form>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div id="edit-form-{{ $comment->id }}" class="edit-comment-form hidden">
                        <form method="POST" action="{{ route('comments.update', $comment->id) }}">
                            @csrf
                            @method('PATCH')
                            <textarea name="content" rows="2" class="w-full p-3 rounded border" style="background-color: #333;">{{ $comment->content }}</textarea>
                            <button type="submit" class="mt-2 inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-green-500 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-green">Update</button>
                            <button type="button" onclick="cancelEdit({{ $comment->id }})" class="mt-2 inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">Cancel</button>
                        </form>                        
                    </div>
                    
                    {{-- Show replies button --}}
                    <div class="flex justify-between items-center mt-2">
                        @if($comment->replies->count() > 0)
                            <button onclick="toggleReplies({{ $comment->id }})" class="text-sm text-blue-500 hover:text-blue-800 focus:outline-none focus:ring-0">
                                View {{ $comment->replies->count() }} replies
                            </button>
                        @endif
                    </div>

                    <!-- Форма для відповіді (прихована за замовчуванням) -->
                    <div id="reply-form-{{ $comment->id }}" class="hidden mt-2">
                        <form method="POST" action="{{ route('comments.store', $post->id) }}">
                            @csrf
                            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                            <textarea name="content" rows="2" class="w-full p-3 rounded border " style="background-color: #333;" placeholder="Write a reply..."></textarea>
                            <button type="submit" class="text-sm bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded mt-1">Submit Reply</button>
                        </form>
                    </div>
                    <div id="replies-{{ $comment->id }}" class="hidden">
                        @foreach ($comment->replies as $reply)
                            <div class="reply">
                                <strong>{{ $reply->user->name }}</strong> - <span>{{ $reply->updated_at->diffForHumans() }}</span>
                                <p>{{ $reply->content }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
        <!-- Fixed Comment Form Section -->
        <div class="fixed-form">
            <form method="POST" action="{{ route('comments.store', $post->id) }}">
                @csrf
                <textarea name="content" rows="1" placeholder="Leave a comment..." required></textarea>
                <button type="submit">
                    Post Comment
                </button>
            </form>
        </div>
    </div>
</div>


<script>
    function toggleMenu(commentId) {
        const menu = document.getElementById(`menu-${commentId}`);
        menu.classList.toggle('hidden');
    }

    function editComment(commentId) {
    const editForm = document.getElementById(`edit-form-${commentId}`);
    const commentBody = document.getElementById(`comment-body-${commentId}`);
    commentBody.style.display = 'none';
    editForm.classList.remove('hidden');
}

function cancelEdit(commentId) {
    const editForm = document.getElementById(`edit-form-${commentId}`);
    const commentBody = document.getElementById(`comment-body-${commentId}`);
    commentBody.style.display = 'block';
    editForm.classList.add('hidden');
}


    function showReplyForm(event, commentId) {
        event.preventDefault();
        const replyForm = document.getElementById(`reply-form-${commentId}`);
        replyForm.classList.toggle('hidden');
    }

    function toggleReplies(commentId) {
        var repliesDiv = document.getElementById('replies-' + commentId);
        if (repliesDiv) {
            repliesDiv.classList.toggle('hidden');
        } 
    }
</script>
@endsection