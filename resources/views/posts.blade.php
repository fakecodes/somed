<!-- resources/views/posts.blade.php -->
@if($posts->isEmpty())
    <p>No posts available.</p>
@else
@foreach($posts as $post)
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <p class="text-gray-500">{{ $post->user->name }}</p>
                <p class="text-gray-500"><small>Posted: {{ $post->humanizedDate }}</small></p>
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @if($post->image)
                        <div class="bg-white p-4 rounded-lg shadow-md">
                            <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="w-full h-32 object-cover rounded-lg mb-4">  
                        </div>
                    @endif
                    <p class="text-white-600">{{ Str::limit($post->text, 100) }}</p>
                </div>

                <!-- Comment Button -->
                <!-- <div class="mt-4">
                    <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Comment
                    </button>
                </div> -->

                <!-- Display existing comments -->
                @if($post->comments->isNotEmpty())
                    <div class="mt-4">
                        <h3 class="text-lg font-semibold">Comments:</h3>
                        @foreach($post->comments as $comment)
                            <div class="mt-2">
                                <p><strong>{{ $comment->user->name }}:</strong> {{ $comment->comment }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Comment Form -->
                <form method="POST" action="{{ route('comments.store', $post->id) }}" class="mt-4">
                    @csrf
                    <textarea name="content" rows="2" class="w-full p-2 border rounded text-black" placeholder="Add a comment..." required></textarea>
                    <button type="submit" class="mt-2 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Post Comment
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>
@endforeach
@endif