<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Dotenv\Validator;
use Faker\Guesser\Name;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{

    //ユーザ登録処理
    public function register(Request $request)
    {
        // フォーム入力情報のエラーチェック
        $request->validate([
            'name' => ['required','unique:users'],
            'email' => ['nullable', 'email', 'unique:users'],
            'password' => 'nullable'
        ]);

        $user = User::Create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password'])
        ]);

        if(!is_null($user)) {
            Auth::guard()->login($user);
            return response()->json(["status_code" => 200, "message" => "登録しました", "data" => $user]);
        }
        else{
            return response()->json(["status_code" => 500, "message" => "登録失敗しました"]);
        }
    }
}
