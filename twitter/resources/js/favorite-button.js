$.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $("[name='csrf-token']").attr("content") },
})
$(document).ready(function(){
    $('.favorite-button').on('click', function(){
        const tweetId = $(this).data('tweet-id'); // クリックされたボタンのtweet-idを取得
        const favoriteVal = $(this).attr("fav_val"); // クリックされたボタンのfav_val属性を取得
        const clickedButton = $(this); // クリックされたボタンを変数に格納
        const favoriteCountSpan = clickedButton.parent().find('.favoriteCount'); // 親要素内からfavoriteCount要素を取得

        if(favoriteVal=='1'){
            unfavoriteTweet(tweetId, clickedButton, favoriteCountSpan);
        } else {
            favoriteTweet(tweetId, clickedButton, favoriteCountSpan);
        }
    });
});


/**
 * いいね解除のAjaxリクエストを送る
 *
 * @param {*} tweetId
 * @param {*} clickedButton
 * @param {*} favoriteCountSpan
 */
function unfavoriteTweet(tweetId, clickedButton, favoriteCountSpan){
    $.ajax({
        url: "/tweet/unfavorite",
        method: "POST",
        data: { tweetId : tweetId },
        dataType: "json",
    }).done(function(data){
        //fav_val属性を更新
        clickedButton.attr('fav_val','0');

        // アイコンのクラスと色を変更
        clickedButton.find('i.fa-solid').removeClass('fa-solid').addClass('fa-regular');
        clickedButton.find('i').css('color', '#202124');
        
        // favoriteCountの数と色を変更
        favoriteCountSpan.html(data.favoriteCount);
        favoriteCountSpan.css('color', '#202124');
    }).fail(handleAjaxError);
}


/**
 * いいねのAjaxリクエストを送る
 *
 * @param {*} tweetId
 * @param {*} clickedButton
 * @param {*} favoriteCountSpan
 */
function favoriteTweet(tweetId, clickedButton, favoriteCountSpan){
    $.ajax({
        url: "/tweet/favorite",
        method: "POST",
        data: { tweetId : tweetId },
        dataType: "json",
    }).done(function(data){
        //fav_val属性を更新
        clickedButton.attr('fav_val','1') 

        // アイコンのクラスと色を変更
        clickedButton.find('i.fa-regular').removeClass('fa-regular').addClass('fa-solid');
        clickedButton.find('i').css('color', '#f91880');

        // favoriteCountの数と色を変更
        favoriteCountSpan.html(data.favoriteCount);
        favoriteCountSpan.css('color', '#f91880');
    }).fail(handleAjaxError);
}

/**
 * エラー対応
 *
 * @param {*} error
 */
function handleAjaxError(error) {
    console.log(error.statusText);
    alert("通信エラーが発生しました。");
}