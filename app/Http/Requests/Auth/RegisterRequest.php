<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Validator;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
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
            'name' => 'required|unique:users|string',
            'email' => 'nullable|unique:users|email',
            'password' => 'nullable|string' 
        ];
    }

    public function messages()
    {
        return [
            'name.required' => ':attributeは必須項目です。',
            'name.unique'=> ':attributeは既に使用されています。',
            'email.unique' => ':attributeは登録できません。',
            'email.email' => '正しいメールアドレスを指定してください。',
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

    protected function failedRegisterValidation(Validator $validator){
        $response['status_code'] = 401;
        $response['statusText'] = 'failed Validation';
        $response['errors'] = $validator->errors()->toArray();

        throw new HttpResponseException(
            response()->json($response, 401)
        );
    }
}
