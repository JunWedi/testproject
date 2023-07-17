<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;

class RecipeController extends Controller
{
    public function index(Recipe $recipe)
    {
        return view('recipes.index')->with(['recipes' => $recipe->get()]);  
    }

    public function show(Recipe $recipe)
    {
    return view('recipes.show')->with(['recipe' => $recipe]);
    }

    public function create()
    {
        return view('recipes.create');
    }

}
