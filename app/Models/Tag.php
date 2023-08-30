<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    //レシピへの多対多のリレーション
    public function recipes(): BelongsToMany
    {
        return $this->belongsToMany(Recipe::class);
    }

    public function getByTag()
    {
        return $this->recipes()->with('tags')->orderBy('updated_at', 'DESC')->get();
    }
}
