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
                        @can('update', $tweet)
                        <div class="dropdown" style="display: inline-block; float: right;">
                            <i class="fa-solid fa-ellipsis text-right" data-bs-toggle="dropdown" aria-expanded="false"></i>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('tweet.edit', $tweet) }}">編集</a></li>
                                <li>
                                    <form method='post' action={{ route('tweet.delete', $tweet) }} onsubmit="return confirm('本当にツイートを削除してもよろしいですか?');">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class=" dropdown-item btn btn-link text-danger">
                                            {{ __('削除') }}
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                        @endcan
                    </h6>
                    <p class="card-text">
                        {{ $tweet->body }}
                    </p>
                    <p>
                        @foreach ($tweet->images as $image)
                            <img src="{{ asset($image->image_path) }}" alt="Image">
                        @endforeach
                    </p>
                    <div style="display: flex; align-items: center;">
                        {{-- リプライボタン --}}
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reply-modal" style="background: transparent; border: none;">
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
            </div>
            {{-- リプライフォーム --}}
            <form method="POST" action="{{ route('reply.store', $tweet->id) }}">
                @csrf
                <div class="mb-3">
                    <textarea class="form-control @error('body') is-invalid @enderror" id="body" rows="3" type="text" name='body' value="{{ old('body') }}"></textarea>
                    @error('body')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                </div>
                <div class="d-grid justify-content-md-end mb-3">
                    <button class="btn btn-outline-primary" type="submit">{{ __('返信') }}</button>
                </div>
            </form>
            {{-- リプライ --}}
            @foreach($tweet->replies as $reply)
            <div class="card bg-white mb-3">
                <div class="card-body">
                    <h6 class="card-title">
                        {{ $reply->user->display_name }}
                        <span class="text-muted">{{ '@' }}{{ $reply->user->user_name }}</span>
                        <span class="text-muted">{{ '・' }}{{ $reply->created_at->format('h:i A · M d, Y') }}</span>
                        @can('update', $reply)
                        <div class="dropdown" style="display: inline-block; float: right;">
                            <i class="fa-solid fa-ellipsis text-right" data-bs-toggle="dropdown" aria-expanded="false"></i>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit-reply-modal-{{ $reply->id }}" href="#">編集</a>
                                </li>
                                <li>
                                    <form method='post' action={{ route('reply.delete', $reply->id) }} onsubmit="return confirm('本当にリプライを削除してもよろしいですか?');">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class=" dropdown-item btn btn-link text-danger">
                                            {{ __('削除') }}
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                        @endcan
                        {{-- リプライ編集のモーダル --}}
                        <form method="POST" action="{{ route('reply.update', $reply->id) }}">
                            @csrf
                            <div class="modal fade" id="edit-reply-modal-{{ $reply->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="message-text" class="col-form-label">リプライ</label>
                                            <textarea class="form-control @error('body') is-invalid @enderror" id="body" rows="3" type="text" name='body'>{{ $reply->body }}</textarea>
                                            @error('body')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="reply-button btn btn-outline-primary" name=submit-button>{{ __('返信') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </h6>
                    <p class="card-text" style="font-size: 15px">
                        {{ $reply->body }}
                    </p>
                </div>
            </div>
            @endforeach
            {{-- リプライのモーダル --}}
            <form method="POST" action="{{ route('reply.store', $tweet->id) }}" name="reply">
                @csrf
                <div class="modal fade" id="reply-modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="message-text" class="col-form-label">リプライ</label>
                                    <textarea class="form-control @error('body') is-invalid @enderror" id="body" rows="3" type="text" name='body'>{{ old('body') }}</textarea>
                                    @error('body')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                             </div>
                        </div>
                        <div class="modal-footer">
                            <button class="reply-button btn btn-outline-primary" name=submit-button>{{ __('返信') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="{{ mix('/js/favorite-button.js') }}"></script>
@endsection
