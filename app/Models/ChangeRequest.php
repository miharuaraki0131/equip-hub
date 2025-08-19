<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ChangeRequest extends Model
{
    use HasFactory;

    protected $fillable = [ // 一括代入
        'user_id',
        'target_model',
        'target_id',
        'type',
        'payload_before',
        'payload_after',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        // JSONカラムを自動的に配列/オブジェクトに変換する設定
        return [
            'payload_before' => 'array',
            'payload_after' => 'array',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | リレーションシップ
    |--------------------------------------------------------------------------
    */

    /**
     * この申請を行ったユーザーを取得
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * この申請の対象となるモデル（Equipmentなど）を取得 (ポリモーフィック)
     */
    public function target(): MorphTo
    {
        // 'target_model', 'target_id' カラムを見て、関連モデルを動的に取得
        return $this->morphTo();
    }

    /**
     * この申請に紐づく承認フローを取得 (ポリモーフィックな1対1)
     */
    public function approvalFlow(): MorphOne
    {
        // 'source_model', 'source_id' を使って ApprovalFlow と繋がる
        return $this->morphOne(ApprovalFlow::class, 'source');
    }
}