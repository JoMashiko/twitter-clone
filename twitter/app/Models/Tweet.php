<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;

class Tweet extends Model
{
    use HasFactory;

    protected $tabel = 'tweets';
    protected $fillable = ['body', 'user_id'];

    /**
     * ツイートを保存する
     * 
     * @param array tweetParam
     * @param int $userId
     */
    public function store(array $tweetParam, int $userId): void
    {
        $this->fill($tweetParam);
        $this->user_id = $userId;
        $this->save();
    }

    /**
     * 全てのツイートを最新順で取得する
     * 
     * @return Collection
     */
    public function getAllTweets(): Collection
    {
        return Tweet::latest()->get();
    }

    /**
     * リレーション
     * 
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * ツイートIDに基づいてツイートを検索し、一致するツイートを返す
     * 
     * @param int $tweetId
     * @return Tweet $tweet
     */
    public function findByTweetId(int $tweetId): Tweet
    {
        return Tweet::findOrFail($tweetId);
    }

    /**
     * ツイートを更新する
     * 
     * @param array $tweetPram
     * @param Tweet $tweet
     */
    public function updateTweet(array $tweetParam, Tweet $tweet): void
    {
        $tweet->fill($tweetParam);
        $tweet->update();
    }

    /**
     * ユーザーを削除する
     */
    public function deleteTweet(): void
    {
        $this->delete();
    }

    /**
     * ツイートを検索する
     *
     * @param string $query
     * @return Collection
     */
    public function searchByQuery(string $query): Collection
    {
        return Tweet::where('body', 'LIKE', '%' . $query . '%')->get();
    }
}
