<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TargetWeightRequest extends FormRequest
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
            'target_weight' => 'required',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $value = $this->input('target_weight');

            if ($value === null || $value === '') {
                return;
            }

            if (preg_match('/\.\d{2,}$/', $value)) {
                $validator->errors()->add('target_weight', '小数点は1桁で入力してください');
                return;
            }

            if (!preg_match('/^\d{1,2}(\.\d{1})?$/', $value)) {
                $validator->errors()->add('target_weight', '4桁までの数字で入力してください');
            }
        });
    }

    public function messages()
    {
        return [
            'target_weight.required' => '目標の体重を入力してください',
        ];
    }
}
