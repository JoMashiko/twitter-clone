<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\Cast\Bool_;
use Ramsey\Uuid\Type\Integer;

class Favorite extends Model
{
    use HasFactory;

    protected $table = 'favorites';
    protected $fillable = ['tweet_id', 'user_id'];

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
     * リレーション
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * ツイートIDに基づくツイートにいいね
     *
     * @param integer $tweetId
     * @param integer $userId
     * @return void
     */
    public function favorite(int $tweetId, int $userId): void
    {
        $this->tweet_id = $tweetId;
        $this->user_id = $userId;
        $this->save();
    }

    /**
     * ツイートIDとユーザーIDに基づいて、いいねを検索
     *
     * @param integer $tweetId
     * @param integer $userId
     * @return Favorite|null
     */
    public function findFavorite(int $tweetId, int $userId): ?Favorite
    {
        return Favorite::where('tweet_id', $tweetId)
            ->where('user_id', $userId)
            ->first();
    }

    /**
     * ツイートIDに基づくツイートのいいねを解除
     *
     * @param Favorite $favorite
     * @return void
     */
    public function unfavorite(Favorite $favorite): void
    {
        $favorite->delete();
    }
}
