<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Follower extends Model
{
    use HasFactory;

    protected $table = 'followers';
    protected $fillable = ['following_id', 'followed_id'];

    public $timestamps = false;

    /**
     * リレーション(followersテーブルのfollowing_idとusersテーブルのidを紐付ける)
     *
     * @return BelongsTo
     */
    public function followingUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'following_id', 'id');
    }

    /**
     * リレーション(followersテーブルのfollowed_idとusersテーブルのidを紐付ける)
     *
     * @return BelongsTo
     */
    public function followedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'followed_id', 'id');
    }

    /**
     * フォロー
     *
     * @param integer $followedUserId
     * @return void
     */
    public function follow(int $followedUserId): void
    {
        $this->following_id = Auth::id();
        $this->followed_id = $followedUserId;
        $this->save();
    }

    /**
     * フォロー解除
     *
     * @param integer $followedUserId
     * @return void
     */
    public function unfollow(int $followedUserId): void
    {
        $this->where([
            ['following_id', Auth::id()],
            ['followed_id', $followedUserId],
        ])->delete();
    }
}
