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
<script>
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $("[name='csrf-token']").attr("content") },
        })
        $(document).ready(function(){
            $('.favorite-button').on('click', function(){
                var tweetId = $(this).data('tweet-id'); // クリックされたボタンのtweet-idを取得
                var fav_val = $(this).attr("fav_val"); // クリックされたボタンのfav_val属性を取得
                var clickedButton = $(this); // クリックされたボタンを変数に格納
                var favoriteCountSpan = clickedButton.parent().find('.favoriteCount'); // 親要素内からfavoriteCount要素を取得

                if(fav_val=='1'){
                    // いいね済の場合
                    $.ajax({
                    url: "/tweet/unfavorite",
                    method: "POST",
                    data: { tweetId : tweetId },
                    dataType: "json",
                    }).done(function(data){
                        // 成功時の処理
                        clickedButton.attr('fav_val','0'); //fav_val属性を更新

                        // アイコンのクラスと色を変更
                        clickedButton.find('i.fa-solid').removeClass('fa-solid').addClass('fa-regular');
                        clickedButton.find('i').css('color', '#202124');
                        
                        // favoriteCountの数と色を変更
                        favoriteCountSpan.html(data.favoriteCount);
                        favoriteCountSpan.css('color', '#202124');
                    }).fail((error) => {
                    console.log(error.statusText);
                    });
                }else{
                    // いいね未の場合
                    $.ajax({
                    url: "/tweet/favorite",
                    method: "POST",
                    data: { tweetId : tweetId },
                    dataType: "json",
                    }).done(function(data){
                        // 成功時の処理
                        clickedButton.attr('fav_val','1') //fav_val属性を更新

                        // アイコンのクラスと色を変更
                        clickedButton.find('i.fa-regular').removeClass('fa-regular').addClass('fa-solid');
                        clickedButton.find('i').css('color', '#f91880');

                        // favoriteCountの数と色を変更
                        favoriteCountSpan.html(data.favoriteCount);
                        favoriteCountSpan.css('color', '#f91880');
                    }).fail((error) => {
                    console.log(error.statusText);
                    });
                }
            });
        });
</script>
@endsection
