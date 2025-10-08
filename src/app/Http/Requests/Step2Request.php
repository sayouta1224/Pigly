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
            'now_weight' => 'required | numeric',
            'target_weight' => 'required | numeric',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            foreach (['now_weight', 'target_weight'] as $field) {
                $value = $this->input($field);

                if ($value === null || $value === '') {
                    continue;
                }

                if (!is_numeric($value)) {
                    continue;
                }

                if (preg_match('/\.\d{2,}$/', $value)) {
                    $validator->errors()->add($field, '小数点は1桁で入力してください');
                    continue;
                }

                if (!preg_match('/^\d{1,2}(\.\d{1})?$/', $value)) {
                $validator->errors()->add($field, '4桁までの数字で入力してください');
                }
            }
        });
    }

    public function messages()
    {
        return[
            'now_weight.required' => '現在の体重を入力してください',
            'now_weight.numeric' => '',
            'target_weight.required' => '目標の体重を入力してください',
            'target_weight.numeric' => '',
        ];
    }
}
