<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;

class UserController extends Controller
{
    public function show(User $user)
    {
        $categories = Category::all();
        $recipes = $user->recipes;

        return view('users.index', [
            'user' => $user,
            'categories' => $categories,
            'recipes' => $recipes
        ]);
    }
}
