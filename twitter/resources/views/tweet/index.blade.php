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
                <div style="display: flex; align-items: center;">
                    {{-- リプライボタン --}}
                        <button type="button" class="reply-button btn btn-primary" data-bs-toggle="modal" data-bs-target="#{{ $tweet->id }}" style="background: transparent; border: none; margin-left: 8px">
                            <i class="fa-regular fa-comment" style="color: #202124;"></i>
                            <span class="replyCount" style="color: #202124; margin-left: 5px;">{{ $tweet->replies->count() }}</span>
                        </button>

                        {{-- いいねボタン  --}}
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
                </div>
                {{-- リプライのモーダル --}}
                <form method="POST" action="{{ route('reply.store', $tweet->id) }}">
                    @csrf
                    <div class="modal fade" id="{{ $tweet->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="message-text" class="col-form-label">リプライ</label>
                                    <textarea class="form-control @error('body') is-invalid @enderror" id="body" rows="3" type="text" name='body' value="{{ old('body') }}"></textarea>
                                    @error('body')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-outline-primary" type="submit">{{ __('返信') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            @endforeach
        </div>
    </div>
</div>
<script src="{{ mix('/js/favorite-button.js') }}"></script>
@endsection
