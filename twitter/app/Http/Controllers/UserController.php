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
     * コンストラクタ
     */
    private $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    /**
     * ユーザーIDに基づいてユーザーを検索し、ユーザー情報を表示する
     * 
     * @param int $userId ユーザーID
     * @return View
     */
    public function findByUserId(int $userId): View
    {
        $user = $this->userModel->findByUserId($userId);

        return view('user.show', compact('user'));
    }

    /**
     * ユーザー編集画面を表示する
     * 
     * @return View
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
     * @param  int $userId ユーザーID
     * @return RedirectResponse
     */
    public function update(UpdateRequest $request, int $userId): RedirectResponse
    {   
        $user = $this->userModel->findByUserId($userId);
        // バリデーション済みデータの取得
        $userParam = $request->validated();
        $user->updateUser($userParam, $user);

        return redirect()->route('user.show', $userId)->with('success', '更新しました');
    }

    /**
     * ユーザーを削除する
     * 
     * @param int $userId ユーザーID
     * @return RedirectResponse
     */
    public function delete(int $userId): RedirectResponse
    {
        $user = $this->userModel->findByUserId($userId);
        $user->deleteUser();

        return redirect()->route('home');
    }

    /**
     * ユーザー一覧を表示する
     * 
     * @return View
     */
    public function getAllUsers(): View
    {
        $users = $this->userModel->getAllUsers();

        return view('user.index', compact('users'));
    }
}