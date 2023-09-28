@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">ユーザー一覧</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>名前</th>
                                <th>メールアドレス</th>
                                <th>ユーザー名</th>
                                <th>登録日</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->display_name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->user_name }}</td>
                                    <td>{{ $user->created_at }}</td>
                                    <td>
                                        @can('followOrUnfollow', $user)
                                        <form method="POST" action="{{ route('user.follow', $user) }}">
                                            @csrf
                                            @can('follow', $user)
                                                <button type="submit" class="btn btn-outline-dark me-md-2">
                                                    {{ __('Follow') }}
                                                </button>
                                            @endcan
                                        </form>
                                        <form method="POST" action="{{ route('user.unfollow', $user) }}">
                                            @csrf
                                            @can('unfollow', $user)
                                                <button type="submit" class="btn btn-outline-dark me-md-2">
                                                    {{ __('UnFollow') }}
                                                </button>
                                            @endcan
                                        </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
