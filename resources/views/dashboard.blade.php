@extends('layouts.albums')

@section('title', "User Dashboard - contains Spotify's top 20 albums and lets user search for specific albums")

@section('content')
    <h1>Welcome, {{ Auth::user()->username }}!</h1>

    <!-- Search bar -->
    <form action="{{ route('albums.search') }}" method="GET" class="search-bar">
        @csrf
        <div class="row justify-content-between">
            <div class="col-11">
                <input type="text" class="form-control" placeholder="Search for an album..." name="query">
            </div>
            <div class="col-1">
                <button type="submit" class="btn btn-primary search-button">Submit</button>
            </div>
        </div>
    </form>

    <div class="row justify-content-between m-3">
        <div class="col">
            @auth
                <a href="{{ route('profile', ['userid' => Auth::id()]) }}" class="btn btn-primary">My Profile</a>
            @endauth
        </div>
        <h2>Today's Top Albums</h2>
        <div class="col text-right">
            @auth
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
            @endauth
        </div>
    </div>
<!-- Spotify's top 20 albums of the day, click to see details -->
    <div class="row">
        @foreach ($albums['albums']['items'] as $item)
            <div class="col-md-4">
                <div class="album-card" onclick="location.href='{{ route('album.details', ['albumId' => $item['id']]) }}';">
                    <img src="{{ $item['images'][0]['url'] }}" alt="{{ $item['name'] }}" class="album-image">
                    <div class="album-details">
                        <h4 class="album-title">{{ $item['name'] }}
                            <form action="{{ route('toggle-favorite') }}" method="POST" class="favorite-form">
                                @csrf
                                <input type="hidden" name="albumId" value="{{ $item['id'] }}">
                                <input type="hidden" name="albumName" value="{{ $item['name'] }}">
                                <input type="hidden" name="albumArtist" value="{{ $item['artists'][0]['name'] }}"> <!-- Assuming only one artist per album -->
                                <button type="submit" class="heart-button">
                                    @if ($item['favorited'])
                                        <i class="fas fa-heart heart-icon favorited"></i>
                                        <span class="favorited-at">{{ $item['favorited_at']->diffForHumans() }}</span>
                                    @else
                                        <i class="far fa-heart heart-icon"></i>
                                    @endif
                                </button>
                            </form>
                        </h4>
                        <p class="album-artists">
                            @foreach ($item['artists'] as $artist)
                                {{ $artist['name'] }}
                                @if (!$loop->last), @endif
                            @endforeach
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
