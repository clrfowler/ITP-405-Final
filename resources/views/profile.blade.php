@extends('layouts.albums')

@section('title', "{{ auth()->user()->username }}'s Profile - contains the user's liked albums and their ratings along with timestamps")

@section('content')
    <h1>{{ auth()->user()->username }}'s Profile</h1>

    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <a href="/dashboard" class="btn btn-primary mb-3"><i class="fas fa-arrow-left mr-2"></i>Back to Dashboard</a>
            </div>
            <div class="col-md-6 d-flex justify-content-end">
                <form action="{{ route('delete-account') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger delete-button"><i class="fas fa-trash"></i> Delete Account</button>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        @if(!$albums)
            <div class="col-md-12">
                <p>No albums liked yet! Like an album to save it to your profile.</p>
            </div>
        @else
            @foreach ($albums as $albumArray)
                @foreach ($albumArray as $album)
                    <div class="col-md-4">
                        <div class="album-card">
                            <div class="image-container" onclick="location.href='{{ route('album.details', ['albumId' => $album['id']]) }}';">
                                <img src="{{ $album['images'][0]['url'] }}" alt="{{ $album['name'] }}" class="album-image">
                            </div>
                            <div class="album-details">
                                <h4 class="album-title">{{ $album['name'] }}
                                    <form action="{{ route('toggle-favorite') }}" method="POST" class="favorite-form">
                                        @csrf
                                        <input type="hidden" name="albumId" value="{{ $album['id'] }}">
                                        <input type="hidden" name="albumName" value="{{ $album['name'] }}">
                                        <input type="hidden" name="albumArtist" value="{{ $album['artists'][0]['name'] }}"> <!-- Assuming only one artist per album -->
                                        <button type="submit" class="heart-button">
                                            @if ($album['favorited'])
                                                <i class="fas fa-heart heart-icon favorited"></i>
                                                <span class="timestamp">{{ $album['updated_at']->diffForHumans() }}</span>
                                            @else
                                                <i class="far fa-heart heart-icon"></i>
                                            @endif
                                        </button>
                                    </form>
                                </h4>
                                <p class="album-artists">
                                    @foreach ($album['artists'] as $artist)
                                        {{ $artist['name'] }}
                                        @if (!$loop->last), @endif
                                    @endforeach
                                    @if ($album['favorited'])
                                        @if ($album['user_rating'])
                                            <p class="user-rating">Your Rating: {{ $album['user_rating'] }}</p>
                                        @endif
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforeach
        @endif
    </div>
@endsection
