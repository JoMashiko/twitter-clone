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
                    <div class="row mb-0">
                        <div class="col-md-6">
                            <a href="{{ route('user.edit', $user) }}" class="btn btn-primary">
                                {{ __('編集') }}
                            </a>
                        </div>
                    </div>                    
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection