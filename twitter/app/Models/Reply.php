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
     * @param array $reply
     * @param integer $userId
     * @return void
     */
    public function store(array $reply, int $userId): void
    {
        $this->fill($reply);
        $this->user_id = $userId;
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
