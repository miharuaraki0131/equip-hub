<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [ // 一括代入を許可
        'name',
        'email',
        'password',
        'division_id',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean', // 管理者かどうか
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | リレーションシップ
    |--------------------------------------------------------------------------
    */


    /**
     *  ユーザーが所属する部署(1つ)
     */
    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }


    /**
     * ユーザーが作成した予約(複数)
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * このユーザーが承認者になっている申請(複数)
     */
    public function approvalFlows(): HasMany
    {
        //  user_id ではなく、approver_idで規約とは外れるので第二引数が必要
        return $this->hasMany(ApprovalFlow::class, 'approver_id');
    }


    /**
     * このユーザーが行った変更申請の一覧（複数）
     */
    public function changeRequests(): HasMany
    {
        return $this->hasMany(ChangeRequest::class);
    }
}
