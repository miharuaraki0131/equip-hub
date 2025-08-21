<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EquipmentRequest extends FormRequest
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
            'name'        => 'required|string|max:255',  //名前は必須で255文字以内
            'category_id' => 'required|integer|exists:categories,id', // カテゴリは必須で、存在するカテゴリIDを指定
            'division_id' => 'nullable|integer|exists:divisions,id', // 部門は任意で、存在する部門IDを指定
            'description' => 'nullable|string', // 説明は任意
            'image'       => 'nullable|image|max:2048', // 画像は任意で、最大サイズは2MB
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
            'name'        => '備品名',
            'category_id' => 'カテゴリ',
            'division_id' => '管理部署',
            'description' => '詳細説明',
            'image'       => '備品画像',
        ];
    }
}
