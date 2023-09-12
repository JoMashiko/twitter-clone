<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use App\Http\Requests\User\UpdateRequest;
use Illuminate\Http\RedirectResponse;

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

    /**
     * ユーザー編集画面を表示するビューを返す
     * 
     * @return View
     * 
     */
    public function edit(): View
    {
        $user = Auth::user();

        return view('user.edit', compact('user'));
    }

    /**
     * 更新内容を受け取り、ユーザー情報を更新する
     * 
     * @param  UserRequest  $request
     * @return RedirectResponse
     * 
     */
    public function update(UpdateRequest $request, int $id): RedirectResponse
    {   
        $user = new User();
        // バリデーション済みデータの取得
        $userParam = $request->validated();
        $user->updateUser($userParam, $id);

        return redirect()->route('user.show', $id)->with('success', '更新しました');
    }
}