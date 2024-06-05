<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    /**
     * Store a newly created user in storage.
     *
     * @param  \App\Http\Requests\CreateUserRequest  $request
     * @return \Illuminate\Http\Response
     */

    public function store(CreateUserRequest $request)
    {
        // バリデーションを通過した場合の処理
        // 新規ユーザーを作成し、データベースに保存するなどの処理を行います
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        // リダイレクトなどの応答を返す
        return redirect()->route('users.index');
    }
}
