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
        </div>
    </div>
</div>
@endsection
