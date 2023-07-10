<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authrized()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|exists:users',
            'email' => 'nullable|email|exists:users',
            'password' => 'nullable|exists:users'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => ':attributeは必須項目です。',
            'name.exists' => '入力された:attributeは登録されていません。',
            'email.email' => '正しいメールアドレスを指定してください。',
            'email.exists' => '入力された:attributeは登録されていません。',
            'password.exists' => ':attributeは正しくありません。',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'ユーザ名',
            'email' => 'メールアドレス',
            'password' => 'パスワード'
        ];
    }

    protected function failedValidation(Validator $validator) {
        $response['status_code']  = 401;
        $response['statusText'] = 'Failed validation.';
        $response['errors']  = $validator->errors();
        throw new HttpResponseException(
            response()->json( $response, 401 )
        );
    }
}
