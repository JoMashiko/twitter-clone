<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tweet\CreateTweetRequest;
use App\Http\Requests\Tweet\UpdateRequest;
use App\Models\Tweet;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Log;

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
        try {
            $userId = Auth::id();
            $tweetParam = $request->validated();
            $this->tweetModel->store($tweetParam, $userId);

            return redirect()->route('tweet.index')->with('success', 'ツイートが保存されました');
        } catch (Exception $e) {
            Log::error($e);

            return redirect()->route('tweet.index')->with('message', 'ツイートできませんでした');
        }
    }

    /**
     * ツイート一覧・検索結果を表示する
     * 
     * @param Request $request
     * @return View
     */
    public function getAllTweets(Request $request): View
    {
        try {
            $query = $request->input('query');
            $tweets = $this->tweetModel->getAllTweets();
            if ($query) {
                $tweets = $this->tweetModel->searchByQuery($query);
            }

            return view('tweet.index', compact('tweets', 'query'));
        } catch (Exception $e) {
            Log::error($e);

            return redirect()->route('tweet.index')->with('message', 'エラーが発生しました');
        }
    }

    /**
     * ツイートIDに基づいてツイートとリプライを検索し、詳細画面を表示する
     * 
     * @param int $tweetId
     * @return View
     */
    public function findByTweetId(int $tweetId)
    {
        try {
            $tweet = $this->tweetModel->findByTweetId($tweetId);
            $replies = $tweet->getReplies();

            return view('tweet.show', compact('tweet', 'replies'));
        } catch (Exception $e) {
            Log::error($e);

            return redirect()->route('tweet.index')->with('message', 'ツイートが見つかりませんでした');
        }
    }

    /**
     * ツイート編集画面を表示する
     * 
     * @param int $tweetId
     * @return View
     */
    public function edit(int $tweetId): View
    {
        $tweet = $this->tweetModel->findByTweetId($tweetId);

        return view('tweet.edit', compact('tweet'));
    }

    /**
     * ツイートを更新する
     * 
     * @param UpdateRequest $request
     * @param int $tweetId
     * @return RedirectResponse
     */
    public function update(UpdateRequest $request, int $tweetId): RedirectResponse
    {
        try {
            $tweetParam = $request->validated();
            $tweet = $this->tweetModel->findByTweetId($tweetId);
            $this->authorize('update', $tweet);
            $tweet->updateTweet($tweetParam, $tweet);

            return redirect()->route('tweet.show', $tweetId)->with('success', '更新しました');
        } catch (Exception $e) {
            Log::error($e);

            return redirect()->route('tweet.show', $tweetId)->with('message', '更新に失敗しました');
        }
    }

    /**
     * ツイートを削除する
     * 
     * @param int $tweetId ユーザーID
     * @return RedirectResponse
     */
    public function delete(int $tweetId): RedirectResponse
    {
        try {
            $tweet = $this->tweetModel->findByTweetId($tweetId);
            $tweet->deleteTweet();

            return redirect()->route('tweet.index')->with('success', 'ツイートを削除しました');
        } catch (Exception $e) {
            Log::error($e);

            return redirect()->route('tweet.index')->with('message', 'ツイートを削除に失敗しました');
        }
    }

    /**
     * ログインユーザーがいいねしたツイート一覧を表示する
     *
     * @return View
     */
    public function getAllFavoriteTweets(): View
    {
        // ログインユーザーがいいねしたすべてのFavoriteレコードを取得
        $favoriteTweets = Auth::user()->favorites;

        return view('tweet.favorite', compact('favoriteTweets'));
    }
}
