<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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
        'status',
    ];

    // 常に読み込むリレーション (N+1問題対策)
    protected $with = ['user', 'targetable'];


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
    public function targetable(): MorphTo // ← メソッド名を targetable に変更
    {
        // 第1引数に関係名を指定し、
        // 第2引数で *_type カラム名、第3引数で *_id カラム名を明示する
        return $this->morphTo('targetable', 'target_model', 'target_id');
    }

    /**
     * この申請に紐づく承認フローを取得 (ポリモーフィックな1対1)
     */
    public function approvalFlow(): MorphOne
    {
        // 'source_model', 'source_id' を使って ApprovalFlow と繋がる
        return $this->morphOne(ApprovalFlow::class, 'source');
    }

    /**
     * ステータスに応じたHTMLバッジを返すアクセサ
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function statusBadge(): Attribute
    {
        return Attribute::make(
            get: function () {
                switch ($this->status) {
                    case 10: // 承認待ち
                        return '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">承認待ち</span>';
                    case 20: // 承認済み
                        return '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">承認済み</span>';
                    case 30: // 却下
                        return '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">却下</span>';
                    default:
                        return '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">不明</span>';
                }
            }
        );
    }
}
