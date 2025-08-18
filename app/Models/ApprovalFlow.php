<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ApprovalFlow extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'source_model',
        'source_id',
        'approver_id',
        'status',
        'comment',
        'processed_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => 'integer',
            'processed_at' => 'datetime',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | リレーションシップ
    |--------------------------------------------------------------------------
    */

    /**
     * この申請を承認する（した）ユーザーを取得
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function approver(): BelongsTo
    {
        // 外部キーが 'approver_id' なので規約通りではないため、第二引数が必要
        return $this->belongsTo(User::class, 'approver_id');
    }

    /**
     * この承認フローの申請元モデル（Reservationなど）を取得 (ポリモーフィック)
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function source(): MorphTo
    {
        // Laravelは、'source_model'と'source_id'カラムを見て、
        // どのモデルのどのIDに紐づいているかを自動的に判断してくれる。
        return $this->morphTo();
    }
}
