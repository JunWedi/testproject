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
            'tag_id' => 'nullable|string|max:10',
        ];
    }

    public function messages()
    {
        return [
            'recipe.title.required' => '料理名は必須です。',
            'recipe.body.required' => '紹介文は必須です。',
            'tag_id.max' => 'タグは10文字以内で入力してください。',
        ];
    }
}
