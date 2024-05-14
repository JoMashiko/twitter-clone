<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reply extends Model
{
    use HasFactory;

    protected $table = 'replies';

    protected $fillable = ['tweet_id', 'user_id', 'body'];

    /**
     * リプライを保存する
     *
     * @param array $replyParam
     * @return void
     */
    public function store(array $replyParam): void
    {
        $this->fill($replyParam);
        $this->save();
    }

    /**
     * リプライを更新する
     *
     * @param array $replyParam
     * @param Reply $reply
     * @return void
     */
    public function updateReply(array $replyParam): void
    {
        $this->fill($replyParam);
        $this->update();
    }

    /**
     * リプライを削除する
     *
     * @return void
     */
    public function deleteReply(): void
    {
        $this->delete();
    }

    /**
     * リレーション
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * リレーション
     *
     * @return void
     */
    public function tweet()
    {
        return $this->belongsTo(Tweet::class);
    }

    /**
     * リプライIDに基づいてリプライを検索し、一致するリプライを返す
     * 
     * @param int $replyId
     * @return Reply
     */
    public function findByReplyId(int $replyId): Reply
    {
        return Reply::findOrFail($replyId);
    }
}
