<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Dotenv\Validator;
use Faker\Guesser\Name;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

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
            Auth::guard()->login($user, true);
            return response()->json(["status_code" => 200, "message" => "登録しました", "user" => $user]);
        }
        else{
            return response()->json(["status_code" => 500, "message" => "登録失敗しました"]);
        }
    }

    //Googleユーザ登録処理
    public function registerProviderUser(Request $request, string $provider)
    {
        $request->validate([
            'name' => ['required', 'string', 'unique:users'],
            'token' => ['required', 'string']
        ]);

        $token = $request->token;

        $providerUser = Socialite::driver($provider)->userFromToken($token);

        $user = User::create([
            'name' => $request->name,
            'email' => $providerUser->getEmail(),
            'password' => null,
        ]);

        Auth::guard()->login($user, true);

        return response()->json(["status_code" => 200, "message" => "登録しました", "user" => $user]);
    }
}
