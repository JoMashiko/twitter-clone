<?php

namespace App\Http\Controllers;

use App\Http\Requests\Reply\CreateReplyRequest;
use App\Http\Requests\Reply\UpdateRequest;
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
            $replyParam = $request->validated();
            $replyParam['user_id'] = Auth::id();
            $replyParam['tweet_id'] = $tweetId;
            $this->reply->store($replyParam);

            return redirect()->route('tweet.show', $tweetId)->with('reply', '保存しました');
        } catch (Exception $e) {
            Log::error($e);

            return redirect()->route('tweet.index')->with('message', '投稿できませんでした');
        }
    }

    /**
     * リプライを更新する
     *
     * @param UpdateRequest $request
     * @param integer $replyId
     * @return RedirectResponse
     */
    public function update(UpdateRequest $request, int $replyId): RedirectResponse
    {
        try {
            $replyParam = $request->validated();
            $reply = $this->reply->findByReplyId($replyId);
            $this->authorize('update', $reply);
            $reply->updateReply($replyParam);

            return back()->with('success', 'リプライを更新しました');
        } catch (Exception $e) {
            Log::error($e);

            return back()->with('message', 'リプライの更新に失敗しました');
        }
    }

    /**
     * リプライを削除する
     * 
     * @param int $tweetId ユーザーID
     * @return RedirectResponse
     */
    public function delete(int $replyId): RedirectResponse
    {
        try {
            $reply = $this->reply->findByReplyId($replyId);
            $this->authorize('delete', $reply);
            $reply->deleteReply();

            return back()->with('success', 'リプライを削除しました');
        } catch (Exception $e) {
            Log::error($e);

            return back()->with('message', 'リプライの削除に失敗しました');
        }
    }
}
