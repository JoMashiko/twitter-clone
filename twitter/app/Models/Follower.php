<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;

class Follower extends Model
{
    use HasFactory;

    protected $table = 'followers';
    protected $fillable = ['following_id', 'followed_id'];

    public $timestamps = false;

    /**
     * リレーション
     *
     * @return belongsToMany
     */
    public function followingUsers(): belongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * リレーション
     *
     * @return belongsToMany
     */
    public function followedUser(): belongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * フォロー
     *
     * @param integer $followingUserId
     * @param integer $followedUserId
     * @return void
     */
    public function follow(int $followingUserId, int $followedUserId): void
    {
        $this->following_id = $followingUserId;
        $this->followed_id = $followedUserId;
        $this->save();
    }

    /**
     * フォロー解除
     *
     * @param integer $followingUserId
     * @param integer $followedUserId
     * @return void
     */
    public function unFollow(int $followingUserId, int $followedUserId): void
    {
        $this->where([
            ['following_id', $followingUserId],
            ['followed_id', $followedUserId],
        ])->delete();
    }

    /**
     * ユーザーが指定したユーザーをフォローしているかどうかを判定
     *
     * @param integer $userId
     * @param integer $targetUserId
     * @return boolean フォローしている場合は true、それ以外の場合は false
     */
    public function isFollowing(int $userId, int $targetUserId): bool
    {
        return Follower::where([
            ['following_id', $userId],
            ['followed_id', $targetUserId],
        ])->exists();
    }

    /**
     * フォローの数をカウントする
     *
     * @param User $user
     * @return integer
     */
    public function countFollowedUsers(User $user): int
    {
        return $user->following()->count();
    }

    /**
     * フォロワーの数をカウントする
     *
     * @param User $user
     * @return integer
     */
    public function countFollowerUsers(User $user): int
    {
        return $user->followers()->count();
    }
}
