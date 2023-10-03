<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class FavoriteController extends Controller
{
    /**
     * コンストラクタ
     */
    private $favoritetModel;

    public function __construct(Favorite $favoriteModel)
    {
        $this->favoritetModel = $favoriteModel;
    }

    /**
     * ツイートIDに基づくツイートをいいねする
     *
     * @param integer $tweetId
     * @return RedirectResponse
     */
    public function favorite(int $tweetId): RedirectResponse
    {
        $userId = Auth::id();
        $this->favoritetModel->favorite($tweetId, $userId);

        return redirect()->route('tweet.index');
    }

    /**
     * ツイートIDに基づくツイートのいいねを解除
     *
     * @param integer $tweetId
     * @return RedirectResponse
     */
    public function unfavorite(int $tweetId): RedirectResponse
    {
        $userId = Auth::id();
        $this->favoritetModel->unfavorite($tweetId, $userId);

        return redirect()->route('tweet.index');
    }
}
