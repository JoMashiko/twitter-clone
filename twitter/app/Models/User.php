<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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

    public function getAuthPassword()
    {
        return $this->{"hash_password"};

    }
}
