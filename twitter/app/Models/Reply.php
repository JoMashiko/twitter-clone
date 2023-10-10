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
     * @param int $tweetId
     * @param integer $userId
     * @param array $reply
     * @return void
     */
    public function store(int $tweetId, int $userId, array $reply): void
    {
        $this->tweet_id = $tweetId;
        $this->user_id = $userId;
        $this->fill($reply);
        $this->save();
    }

    public function updateReply(): void
    {
    }

    public function deleteReply(): void
    {
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tweet()
    {
        return $this->belongsTo(Tweet::class);
    }
}
