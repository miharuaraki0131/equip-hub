<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Reservation;
use Illuminate\Validation\Validator;

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
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            // start_dateとend_dateが有効な場合のみ、重複チェックを実行
            $startDate = $this->input('start_date');
            $endDate = $this->input('end_date');
            $equipmentId = $this->input('equipment_id');

            if ($startDate && $endDate && $equipmentId) {
                $isReserved = Reservation::where('equipment_id', $equipmentId)
                    ->where(function ($query) use ($startDate, $endDate) {
                        $query->where(function ($q) use ($startDate, $endDate) {
                            $q->where('start_date', '<=', $startDate)
                                ->where('end_date', '>=', $startDate);
                        })->orWhere(function ($q) use ($startDate, $endDate) {
                            $q->where('start_date', '<=', $endDate)
                                ->where('end_date', '>=', $endDate);
                        })->orWhere(function ($q) use ($startDate, $endDate) {
                            $q->where('start_date', '>=', $startDate)
                                ->where('end_date', '<=', $endDate);
                        });
                    })
                    ->exists();

                if ($isReserved) {
                    // もし予約が存在したら、エラーメッセージを追加
                    $validator->errors()->add('start_date', '指定された期間には、すでに他の予約が入っています。');
                }
            }
        });
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
