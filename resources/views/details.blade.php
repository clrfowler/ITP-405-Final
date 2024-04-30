<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Album Details - displays the cover art, artists, and release dates for an album; lets user comment and rate</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Add your custom styles here */
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-top: 50px;
        }
        .album-details {
            text-align: center;
            margin-bottom: 20px;
        }
        .album-image {
            width: 300px; 
            height: auto;
            margin-bottom: 20px;
        }
        .album-title {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .album-artists {
            font-style: italic;
            margin-bottom: 20px;
        }
        .album-release {
            margin-bottom: 20px;
        }
        .comment-section {
            margin-top: 30px;
            width: 100%;
        }
        .comment-box {
            margin-bottom: 20px;
        }
        .list-group {
            width: 100%;
            padding-left: 0;
        }
        .list-group-item {
            border: none;
            background-color: #f8f9fa;
            border-radius: 0;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Album Details</h1>
    <a href="{{ route('dashboard') }}" class="btn btn-secondary mb-3">Back to Dashboard</a>

    <div class="album-details">
        <img src="{{ $album['images'][0]['url'] }}" alt="{{ $album['name'] }}" class="album-image">
        <h2 class="album-title">{{ $album['name'] }}</h2>
        <p class="album-artists">
            Artists:
            @foreach ($album['artists'] as $artist)
                {{ $artist['name'] }}
                @if (!$loop->last), @endif
            @endforeach
        </p>
        <p class="album-release">Release Date: {{ \Carbon\Carbon::parse($album['release_date'])->format('F j, Y') }}</p>

            <!-- Display the rating or edit form -->
            @if ($userRating)
                <p class="album-rating">Your Rating: {{ $userRating->rating }}</p>
                <form action="{{ route('ratings.update', $userRating->id) }}" method="POST" class="comment-box">
                    @csrf
                    @method('PUT')
                    <label for="rating">New Rating:</label>
                    <input type="number" id="rating" name="rating" min="0" max="100">
                    <button type="submit" class="btn btn-primary mt-2">Update</button>
                </form>
            @else
                <p class="album-rating">You haven't rated this album yet.</p>
                <form action="{{ route('ratings.store') }}" method="POST" class="comment-box">
                    @csrf
                    <input type="hidden" name="album_id" value="{{ $album['id'] }}">
                    <label for="rating">Rating:</label>
                    <input type="number" id="rating" name="rating" min="0" max="100">
                    <button type="submit" class="btn btn-primary mt-2">Submit</button>
                </form>
            @endif
        </div>
    </div>
        <div class="comment-section m-5">
            <h2>Comments</h2>
            @if ($comments->isEmpty())
                <p>No comments yet, be the first!</p>
            @else
                <ul class="list-group">
                    @foreach ($comments as $comment)
                        <li class="list-group-item">
                            <strong>{{ $comment->user->username }}</strong>: {{ $comment->comment_text }} 
                            <span class="timestamp">{{ $comment->created_at->diffForHumans() }}</span>
                            @if(auth()->check() && $comment->user_id === auth()->id())
                                <a href="{{ route('comments', $comment->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
            <!-- Add comment form here -->
            <form action="{{ route('comments.store') }}" method="POST" class="comment-box m-5">
                @csrf
                <input type="hidden" name="album_id" value="{{ $album['id'] }}">
                <textarea name="comment" class="form-control" placeholder="Write your comment here..." rows="4"></textarea>
                <button type="submit" class="btn btn-primary mt-2">Submit</button>
            </form>
        </div>
    </div>
</body>
</html>
