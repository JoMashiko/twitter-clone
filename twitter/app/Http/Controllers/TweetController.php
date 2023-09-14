<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tweet\CreateTweetRequest;
use App\Models\Tweet;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TweetController extends Controller
{
    /**
     * コンストラクタ
     */
    private $tweetModel;

    public function __construct(Tweet $tweetModel)
    {
        $this->tweetModel = $tweetModel;
    }

    /**
     * ツイート投稿画面を表示する
     *  
     * @return View
     */
    public function create(): View
    {
        return view('tweet.create');
    }

    /**
     * ツイート内容を受け取り、データベースに保存する
     * 
     * @param CreateTweetRequest $request
     * @return RedirectResponse
     */
    public function store(CreateTweetRequest $request): RedirectResponse
    {
        $userId = Auth::id();
        $tweetParam = $request->validated();
        $this->tweetModel->store($tweetParam, $userId);

        return redirect()->route('tweet.index')->with('success', 'ツイートが保存されました');
        
    }

    /**
     * ツイート一覧を表示する
     * 
     * @return View
     */
    public function getAllTweets(): View
    {
       $tweets = $this->tweetModel->getAllTweets();

       return view('tweet.index', compact('tweets'));
    }
}
