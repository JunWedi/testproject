<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Http\Requests\RecipeRequest;
use App\Models\Category;

class RecipeController extends Controller
{

    //レシピの一覧表示
    public function index(Recipe $recipe)
    {
        return view('recipes.index')->with(['recipes' => $recipe->get()]);  
    }

    //レシピの詳細表示
    public function show(Recipe $recipe)
    {
    return view('recipes.show')->with(['recipe' => $recipe]);
    }

    //レシピの編集
    public function edit(Recipe $recipe)
    {
        return view('recipes.edit')->with(['recipe' => $recipe]);
    }

    //レシピの編集更新
    public function update(RecipeRequest $request, Recipe $recipe)
    {
        $input_recipe = $request['recipe'];
        $recipe->fill($input_recipe)->save();

        return redirect('/recipes/' . $recipe->id);
    } 
  
    //レシピの作成、カテゴリーの登録
   public function create(Category $category)
   {
        return view('recipes.create')->with(['categories' => $category->get()]);
   }
   
   //レシピとカテゴリーの保存
   public function store(RecipeRequest $request, Recipe $recipe)
   {
        $input_recipe = $request['recipe'];

        $recipe->fill($input_recipe)->save();

        $recipe->categories()->attach($request->category_id); 
        return redirect('/recipes');
   }

}
