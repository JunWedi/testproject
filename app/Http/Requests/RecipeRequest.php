<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecipeRequest extends FormRequest
{
    public function rules()
    {
        return [
            'recipe.title' => 'required|string|max:100',
            'recipe.body' => 'required|string|max:4000',
        ];
    }
}