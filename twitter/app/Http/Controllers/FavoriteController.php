<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Tweet;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class FavoriteController extends Controller
{
    /**
     * コンストラクタ
     */
    private $favoriteModel;
    private $tweetModel;

    public function __construct(Favorite $favoriteModel, Tweet $tweetModel)
    {
        $this->favoriteModel = $favoriteModel;
        $this->tweetModel = $tweetModel;
    }

    /**
     * ツイートIDに基づくツイートをいいねする
     *
     * @return JsonResponse
     */
    public function favorite(): JsonResponse
    {
        $tweetId = request()->get('tweetId');
        $userId = Auth::id();

        // いいねの処理
        $this->favoriteModel->favorite($tweetId, $userId);

        // いいねの数を取得
        $tweet = $this->tweetModel->findTweetAndRepliesByTweetId($tweetId);
        $favoriteCount = $tweet->favoriteCount();

        return response()->json(['favoriteCount' => $favoriteCount]);
    }

    /**
     * ツイートIDに基づくツイートのいいねを解除
     *
     * @return JsonResponse
     */
    public function unfavorite(): JsonResponse
    {
        $tweetId = request()->get('tweetId');
        $userId = Auth::id();

        // いいね解除処理
        $favorite = $this->favoriteModel->findFavorite($tweetId, $userId);
        if ($favorite) {
            $this->favoriteModel->unfavorite($favorite);
        }

        // いいねの数を取得
        $tweet = $this->tweetModel->findTweetAndRepliesByTweetId($tweetId);
        $favoriteCount = $tweet->favoriteCount();

        return response()->json(['favoriteCount' => $favoriteCount]);
    }
}
