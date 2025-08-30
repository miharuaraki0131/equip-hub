<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Division extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];


    /*
    |--------------------------------------------------------------------------
    | リレーションシップ
    |--------------------------------------------------------------------------
    */

    /**
     * この部署に所属するユーザーの一覧を取得 (Divisionは多くのUserを持つ)
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * この部署が管理する備品の一覧を取得 (Divisionは多くのEquipmentを持つ)
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function equipments(): HasMany
    {
        return $this->hasMany(Equipment::class);
    }
}
