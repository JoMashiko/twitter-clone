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
    private $favoritetModel;
    private $tweetModel;

    public function __construct(Favorite $favoriteModel, Tweet $tweetModel)
    {
        $this->favoritetModel = $favoriteModel;
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
        $this->favoritetModel->favorite($tweetId, $userId);

        // いいねの数を取得
        $tweet = $this->tweetModel->findByTweetId($tweetId);
        $favoriteCount = $tweet->favorites->count();

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
        $this->favoritetModel->unfavorite($tweetId, $userId);

        // いいねの数を取得
        $tweet = $this->tweetModel->findByTweetId($tweetId);
        $favoriteCount = $tweet->favorites->count();

        return response()->json(['favoriteCount' => $favoriteCount]);
    }
}
