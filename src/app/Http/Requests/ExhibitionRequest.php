<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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

    protected $errorBag = 'exhibition';

    public function rules()
    {
        return [
            'name' => 'required',
            'image' => 'required|mimes:jpeg,png',
            'description' => 'required|max:255',
            'categories' => 'required',
            'condition_id' => 'required',
            'price' => 'required|numeric|min:0',
        ];
    }

    public function messages(){

        return [
            'name.required' => '商品名を入力してください',
            'image.required' => '商品画像をアップロードしてください',
            'image.mimes' => '拡張子が.jpegもしくは.pngのファイルをアップロードしてください',
            'description.required' => '商品説明を入力してください',
            'description.max' => '商品説明は255文字以内で入力してください',
            'categories.required' => 'カテゴリーを1つ以上選択してください',
            'condition_id.required' => '商品の状態を選択してください',
            'price.required' => '価格を入力してください',
            'price.numeric' => '数値で入力してください',
            'price.min' => '0円以上で入力してください',
        ];
    }
}
