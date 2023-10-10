@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            @if(session('reply'))
                <div class="alert alert-success">
                    {{ session('reply') }}
                </div>
            @endif
            <div class="card bg-white mb-3">
                <div class="card-body">
                    <h6 class="card-title">
                        {{ $tweet->user->display_name }}
                        <span class="text-muted">{{ '@' }}{{ $tweet->user->user_name }}</span>
                        <span class="text-muted">{{ '・' }}{{ $tweet->created_at->format('h:i A · M d, Y') }}</span>
                    </h6>
                    <p class="card-text">
                        {{ $tweet->body }}
                    </p>
                    <div style="display: flex; align-items: center;">
                        {{-- リプライボタン(tiriger modal) --}}
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" style="background: transparent; border: none;">
                            <i class="fa-regular fa-comment" style="color: #202124;"></i>
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
                    @can('update', $tweet)
                    <div class="d-grid d-md-flex justify-content-md-end">
                        <button type="button" class="btn btn-outline-dark me-md-2" onclick="location.href='{{ route('tweet.edit', $tweet) }}'">
                            {{ __('編集') }}
                        </button>
                        <form method='post' action={{ route('tweet.delete', $tweet) }} onsubmit="
                            return confirm('本当にツイートを削除してもよろしいですか？');">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger mx-2">
                                    {{ __('削除') }}
                                </button>
                            </form>
                        </div>
                    @endcan
                </div>
            </div>
            {{-- Modal --}}
            <form method="POST" action="{{ route('reply.store', $tweet->id) }}">
                @csrf
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <button class="reply-button btn btn-outline-primary">{{ __('返信') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="{{ mix('/js/favorite-button.js') }}"></script>
@endsection
