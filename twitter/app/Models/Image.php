<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $table = 'images';

    protected $fillable = ['tweet_id', 'user_id', 'image_path'];

    /**
     * 画像のパスを保存する
     *
     * @param integer $tweetId
     * @param string $image_path
     * @return void
     */
    public function store(int $tweetId, string $image_path): void
    {
        $this->tweet_id = $tweetId;
        $this->image_path = $image_path;
        $this->save();
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
}
