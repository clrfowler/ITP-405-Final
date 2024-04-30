@extends('layouts.albums')

@section('title', 'Search Results for user query')

@section('content')
    <h1>Search Results for "{{ old('query', $query) }}"</h1>

    <a href="/dashboard" class="btn btn-primary mb-3"><i class="fas fa-arrow-left mr-2"></i>Back to Dashboard</a>

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
                                <input type="hidden" name="albumArtist" value="{{ $item['artists'][0]['name'] }}">
                                <button type="submit" class="heart-button">
                                    @if ($item['favorited'])
                                        <i class="fas fa-heart heart-icon favorited"></i>
                                        <span class="timestamp">{{ $item['updated_at']->diffForHumans() }}</span>
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
