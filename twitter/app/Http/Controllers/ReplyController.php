<?php

namespace App\Http\Controllers;

use App\Http\Requests\Reply\CreateReplyRequest;
use App\Models\Reply;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReplyController extends Controller
{
    /**
     * コンストラクタ
     */
    private $reply;

    public function __construct(Reply $reply)
    {
        $this->reply = $reply;
    }

    /**
     * リプライを保存する
     *
     * @param CreateReplyRequest $request
     * @param integer $tweetId
     * @return RedirectResponse
     */
    public function store(CreateReplyRequest $request, int $tweetId): RedirectResponse
    {
        try {
            $reply = $request->validated();
            $userId = Auth::id();
            $this->reply->store($tweetId, $userId, $reply);

            return redirect()->route('tweet.show', $tweetId)->with('reply', '保存しました');
        } catch (Exception $e) {
            Log::error($e);

            return redirect()->route('tweet.index')->with('message', '投稿できませんでした');
        }
    }
}
