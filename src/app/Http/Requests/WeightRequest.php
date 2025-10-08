<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WeightRequest extends FormRequest
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
            'date' => 'required',
            'weight' => 'required | numeric',
            'calories' => 'required | numeric',
            'exercise_time' => 'required',
            'exercise_content' => 'max:120',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $value = $this->input('weight');

            if ($value === null || $value === '') {
                return;
            }

            if (preg_match('/\.\d{2,}$/', $value)) {
                $validator->errors()->add('weight', '小数点は1桁で入力してください');
                return;
            }

            if (!preg_match('/^\d{1,2}(\.\d{1})?$/', $value)) {
                $validator->errors()->add('weight', '4桁までの数字で入力してください');
            }
        });
    }

    public function messages()
    {
        return [
            'date.required' => '日付を入力してください',
            'weight.required' => '体重を入力してください',
            'weight.numeric' => '数字で入力してください',
            'calories.required' => '摂取カロリーを入力してください',
            'calories.numeric' => '数字で入力してください',
            'exercise_time.required' => '運動時間を入力してください',
            'exercise_content.max:120' => '120文字以内で入力してください',
        ];
    }
}