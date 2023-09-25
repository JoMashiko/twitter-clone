<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users'; //テーブル名
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'display_name',
        'email',
        'birthday',
        'hash_password',
        'profile_image',
        'header_image',
        'user_name',
        'bio_text',
        'last_login_date',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'hash_password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAuthPassword()
    {
        return $this->{"hash_password"};
    }

    /**
     * ユーザーIDに基づいてユーザーを検索し、一致するUserを返す。
     * 
     * @param int $id ユーザーID
     * @return User|null
     */
    public function findByUserId(int $id): User
    {
        $user = $this->find($id);

        return $user;
    }

    /**
     * ユーザー情報を更新する
     * 
     * @param array $userParam
     * @param User $user
     */
    public function updateUser(array $userParam, User $user): void
    {
        $user->fill($userParam);
        $user->save();
    }

    /**
     * ユーザーを削除する
     */
    public function deleteUser(): void
    {
        $this->delete();
    }

    /**
     * すべてのユーザーを取得する
     * 
     * @return Collection
     */
    public function getAllUsers(): Collection
    {
        return User::all();
    }

    /**
     * リレーション
     * 
     * @return HasMany
     */
    public function tweets(): HasMany
    {
        return $this->hasMany(Tweet::class);
    }

    /**
     * リレーション(usersテーブルのidとfollowersテーブルのfollowing_idを紐付ける)
     *
     * @return HasMany
     */
    public function follows(): HasMany
    {
        return $this->hasmany(Follower::class, 'following_id', 'id');
    }

    /**
     * リレーション(usersテーブルのidとfollowersテーブルのfollowed_idを紐付ける)
     *
     * @return HasMany
     */
    public function followers(): HasMany
    {
        return $this->hasmany(Follower::class, 'followed_id', 'id');
    }
}
