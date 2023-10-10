<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReplyRequest;
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

    public function store(CreateReplyRequest $request): JsonResponse
    {
        try {
            $reply = $request->validated();
            $userId = Auth::id();
            $this->reply->store($reply, $userId);

            return redirect()->json();
        } catch (Exception $e) {
            Log::error($e);

            return redirect()->route('tweet.index')->with('message', '投稿できませんでした');
        }
    }
}
