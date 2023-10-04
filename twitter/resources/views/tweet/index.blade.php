@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('message'))
                <div class="alert alert-success" role="alert">
                    {{ session('message') }}
                </div>
            @endif
            @foreach($tweets as $tweet)
            <div class="card bg-white mb-3">
                <a href="{{ route('tweet.show', $tweet->id) }}" class="card-body" style="text-decoration: none; color: inherit;">
                    <h6 class="card-title">
                        {{ $tweet->user->display_name }}
                        <span class="text-muted">{{ '@' }}{{ $tweet->user->user_name }}</span>
                        <span class="text-muted">{{ '・' }}{{ $tweet->created_at->format('h:i A · M d, Y') }}</span>
                    </h6>
                    <p class="card-text">
                        {{ $tweet->body }}
                    </p>
                </a>
                <div style="margin-left: 20px">
                    @if($tweet->isFavorite($tweet->id, auth()->id()))
                        {{-- いいね済 --}}
                        <button class="favorite-button" fav_val="1" style="background: transparent; border: none;" data-tweet-id={{ $tweet->id }}>
                            <i class="fa-solid fa-heart" style="color: #f91880;"></i>
                            <span class="favoriteCount" style="color: #f91880; margin-left: 5px;">{{ $tweet->favorites->count() }}</span>
                        </button>
                    @else
                        {{-- いいね未 --}}
                        <button class="favorite-button" fav_val="0" style="background: transparent; border: none;" data-tweet-id={{ $tweet->id }}>
                            <i class="fa-regular fa-heart" style="color: #202124;"></i>
                            <span class="favoriteCount" style="color: #202124; margin-left: 5px;">{{ $tweet->favorites->count() }}</span>
                        </button>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<script src="{{ mix('/js/favorite-button.js') }}"></script>
@endsection
