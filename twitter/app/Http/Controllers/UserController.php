<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;

class UserController extends Controller
{
    /**
     * ユーザーIDに基づいてユーザーを検索し、ユーザー情報を表示するビューを返す。
     * 
     * @param int $id ユーザーID
     * @return View
     *
     */
    public function findByUserId(int $id): View
    {
        $userModel = new User();
        $user = $userModel->findByUserId($id);

        return view('user.show', compact('user'));
    }
}