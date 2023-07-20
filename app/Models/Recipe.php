<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Recipe extends Model
{
    use HasFactory;

    //レシピテーブルへのfill
    protected $fillable = [
        'title',
        'body',
    ];

    protected $guarded = ['id'];
    
    //カテゴリーへの多対多のリレーション
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    //タグへの多対多のリレーション
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
}