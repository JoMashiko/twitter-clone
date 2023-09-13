<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    use HasFactory;

    protected $tabel = 'tweets';
    protected $fillable = ['body', 'user_id'];

    /**
     * ツイートを保存する
     * 
     * @param array %tweetParam
     * @param int $userId
     */
    public function store(array $tweetParam, int $userId): void
    {
        $this->fill($tweetParam);
        $this->user_id = $userId;
        $this->save();
    }


}
