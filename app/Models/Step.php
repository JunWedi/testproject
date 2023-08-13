<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    use HasFactory;

    protected $fillable = [
        'step_number',  // ステップ番号
        'description',  // ステップの説明
        'recipe_id',
        'image_path',
    ];

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }

}