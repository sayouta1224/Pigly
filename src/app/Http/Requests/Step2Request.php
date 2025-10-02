<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Step2Request extends FormRequest
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
    public function rules()
    {
        return [
            'now_weight' => 'required | digits_between:0,4 | regex:1',
            'target_weight' => 'required | digits_between:0,4 | regex:1',
        ];
    }

    public function messages()
    {
        return[
            'now_weight.required' => '現在の体重を入力してください',
            'now_weight.digits_between:0,4' => '4桁までの数字で入力してください',
            'now_weight.regex:1' => '小数点は1桁で入力してください',
            'target_weight.required' => '目標の体重を入力してください',
            'target_weight.digits_between:4' => '4桁までの数字で入力してください',
            'target_weight.regex:1' => '小数点は1桁で入力してください',
        ];
    }
}
