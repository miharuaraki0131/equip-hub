<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;


    protected $fillable = [
        'name',
    ];

    /*
    |--------------------------------------------------------------------------
    | リレーションシップ
    |--------------------------------------------------------------------------
    */


    /**
     * このカテゴリに属する備品の一覧を取得 (Categoryは多くのEquipmentを持つ)
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function equipments()
    {
        return $this->hasMany(Equipment::class);
    }
}
