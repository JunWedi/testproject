<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Http\Requests\RecipeRequest;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Ingredient;
use App\Models\Step;

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
        //レシピデータの取得
        $input_recipe = $request['recipe'];

        //レシピの保存とカテゴリーIDのリレーション
        $recipe->fill($input_recipe)->save();
        $recipe->categories()->attach($request->category_id); 

        //レシピとタグのリレーション
        $tags = array_map('trim', explode('#', $request->tag_id));
        foreach ($tags as $tag) {
            if(!empty($tag)){
            $tagModel = Tag::firstOrCreate(['name' => $tag]);
            $recipe->tags()->attach($tagModel->id);
            }
        }
        
        //材料
        $ingredient_names = $request->input('ingredient_names');
        $ingredient_quantities = $request->input('ingredient_quantities');
        $ingredient_units = $request->input('ingredient_units');

        for ($i = 0; $i < count($ingredient_names); $i++) {
            $ingredient = new Ingredient;
            $ingredient->name = $ingredient_names[$i] . " " . $ingredient_quantities[$i] . " " . $ingredient_units[$i];
            $ingredient->recipe_id = $recipe->id;
            $ingredient->save();
        }

        //作り方(step)
        $step_numbers = $request->input('step_numbers');
        $step_descriptions = $request->input('step_descriptions');

         for ($i = 0; $i < count($step_numbers); $i++) {
            $step = new Step;
            $step->recipe_id = $recipe->id;
            $step->step_number = $step_numbers[$i];
            $step->description = $step_descriptions[$i];
            $step->save();
        }

        return redirect('/recipes');
   }

}
