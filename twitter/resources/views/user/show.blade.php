@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('マイページ') }}</div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <p>{{ __('名前: ') . $user->display_name }}</p>
                    <p>{{ __('メールアドレス: ') . $user->email }}</p>
                    <p>{{ __('誕生日: ') . $user->birthday }}</p>
                    <p>{{ __('ユーザーネーム: ') . $user->user_name }}</p>
                    <p>{{ __('自己紹介: ') . $user->bio_text }}</p>
                   <p>
                        <a href="{{ route('user.followed') }}">
                            {{ $followedCount }} 
                            <span style="margin-right: 10px">Following</span>
                        </a>
                        <a href="{{ route('user.follower') }}">{{ $followerCount }} Follower</a>
                    </p>
                        
                    <div class="d-flex d-grid justify-content-md-end">
                        <button type="button" class="btn btn-outline-dark" onclick="location.href='{{ route('user.edit', $user) }}'">
                            {{ __('編集') }}
                        </button>
                        <form method='post' action={{ route('user.delete', $user) }} onsubmit="
                        return confirm('本当にアカウントを削除してもよろしいですか？');">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger mx-2">
                                {{ __('削除') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection