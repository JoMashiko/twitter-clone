<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class Image extends Model
{
    use HasFactory;

    protected $table = 'images';

    protected $fillable = ['tweet_id', 'user_id', 'image_path'];

    /**
     * 画像を保存する
     *
     * @param UploadedFile $uploadedFile
     * @param string $dirName
     * @param string $fileName
     * @return void
     */
    public function saveImage(UploadedFile $uploadedFile, string $dirName, string $fileName): void
    {
        $uploadedFile->storeAs('public/' . $dirName, $fileName);
    }

    /**
     * 画像のパスをデータベースに保存する
     *
     * @param integer $tweetId
     * @param string $image_path
     * @return void
     */
    public function saveImagePath(int $tweetId, string $imagePath): void
    {
        $this->tweet_id = $tweetId;
        $this->image_path = $imagePath;
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
