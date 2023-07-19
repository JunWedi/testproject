<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
    ];

    protected $guarded = ['id'];
    
    public function recipes(): BelongsToMany
    {
        return $this->belongsToMany(Recipe::class);
    }

}