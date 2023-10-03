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
                        <a href="{{ route('tweet.unFavorite', $tweet->id) }}" style="text-decoration: none;">
                            <i class="fa-solid fa-heart" style="color: #f91880;"></i>
                            <span style="color: #f91880; margin-left: 5px;">{{ $tweet->favorites->count() }}</span>
                        </a>
                    @else
                        <a href="{{ route('tweet.favorite', $tweet->id) }}" style="text-decoration: none;">
                            <i class="fa-regular fa-heart" style="color: #202124;"></i>
                            <span style="color: #202124; margin-left: 5px;">{{ $tweet->favorites->count() }}</span>
                        </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
