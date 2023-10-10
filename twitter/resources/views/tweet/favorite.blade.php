@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form method="GET" action="{{ route('tweet.index') }}">
                <div class="input-group" style="margin-bottom: 20px">
                    @if(isset($query))
                        <input type="text"  name='query' class="form-control" value="{{ $query }}">
                    @else
                        <input type="text"  name='query' class="form-control" placeholder="キーワードを入力">
                    @endif
                    <button class="btn btn-outline-dark" type="submit" id="button-addon2" ><i class="fas fa-search"></i> 検索</button>
                </div>
            </form>
            @foreach($favoriteTweets as $favoriteTweet)
                <div class="card bg-white mb-3">
                    <a href="{{ route('tweet.show', $favoriteTweet->tweet->id) }}" class="card-body" style="text-decoration: none; color: inherit;">
                        <h6 class="card-title">
                            {{ $favoriteTweet->tweet->user->display_name }}
                            <span class="text-muted">{{ '@' }}{{ $favoriteTweet->tweet->user->user_name }}</span>
                            <span class="text-muted">{{ '・' }}{{ $favoriteTweet->tweet->created_at->format('h:i A · M d, Y') }}</span>
                        </h6>
                        <p class="card-text">
                            {{ $favoriteTweet->tweet->body }}
                        </p>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
<script src="{{ mix('/js/favorite-button.js') }}"></script>
@endsection
