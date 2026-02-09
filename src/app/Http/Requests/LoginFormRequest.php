<?php

namespace App\Http\Requests;

use Laravel\Fortify\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginFormRequest extends LoginRequest
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
     * @return array
     */
    public function rules():array
    {
        return [
            'email' => 'required',
            'password' =>'required',
        ];
    }

    public function messages():array{
        return [
            'email.required' => 'メールアドレスを入力してください',
            'password.required' => 'パスワードを入力してください',
        ];
    }

    public function withValidator($validator){

        $validator->after(function($validator){
        $email = $this->input('email');
        $password = $this->input('password');

        if(!$email || !$password) {return;}

        $user = User::where('email',$email)->first();

        if(!$user || !Hash::check($password, $user->password)){
            $validator->errors()->add('email','ログイン情報が登録されていません。');
        }
    });
    }
}