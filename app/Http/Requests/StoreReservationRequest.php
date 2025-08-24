<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'equipment_id' => 'required|integer|exists:equipments,id',
            'start_date'   => 'required|date|after_or_equal:today',
            'end_date'     => 'required|date|after_or_equal:start_date',
        ];
    }

    /**
     * バリデーションエラーのカスタム属性名を定義
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'start_date'        => '貸出開始日',
            'end_date'          => '貸出終了日',
        ];
    }

    public function messages(): array
    {
        return [
            'start_date.after_or_equal' => ':attributeには、今日以降の日付を指定してください。',
        ];
    }
}
