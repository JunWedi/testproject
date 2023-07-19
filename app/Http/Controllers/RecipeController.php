<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Http\Requests\RecipeRequest;

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

    public function edit(Recipe $recipe)
    {
        return view('recipes.edit')->with(['recipe' => $recipe]);
    }

    public function update(RecipeRequest $request, Recipe $recipe)
    {
        $input_recipe = $request['recipe'];
        $recipe->fill($input_recipe)->save();

        return redirect('/recipes/' . $recipe->id);
    } 

}
