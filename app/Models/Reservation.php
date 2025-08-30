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
}
