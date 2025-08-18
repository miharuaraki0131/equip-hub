<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Reservation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'equipment_id',
        'start_date',
        'end_date',
        'status',
        'rented_at',
        'returned_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'rented_at' => 'datetime',
            'returned_at' => 'datetime',
            'status' => 'integer',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | リレーションシップ
    |--------------------------------------------------------------------------
    */

    /**
     * この予約を行ったユーザーを取得 (Reservationは1人のUserに属する)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * この予約の対象備品を取得 (Reservationは1つのEquipmentに属する)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    /**
     * この予約に紐づく承認フローを取得 (ポリモーフィックな1対1)
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */


    public function approvalFlow(): MorphOne
    {
        // 第1引数: 関連するモデル
        // 第2引数: ポリモーフィック接頭辞 ('source')　source_modelとsource_idを見に行く
        // モデルとidがあることによって一意になる（）
        return $this->morphOne(ApprovalFlow::class, 'source');
    }
}
