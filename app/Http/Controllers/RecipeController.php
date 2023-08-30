<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Http\Requests\RecipeRequest;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Ingredient;
use App\Models\Step;
use Illuminate\Support\Facades\Log;

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
        $recipe = $recipe->load(['ingredients']); //材料の表示
        return view('recipes.show')->with(['recipe' => $recipe]);
    }

    //レシピの編集
    public function edit(Recipe $recipe)
    {
        $this->authorize('update', $recipe);

        $categories = Category::all();

        foreach ($recipe->ingredients as $ingredient) {
            $parts = explode(' ', $ingredient->name);
            $ingredient->name = $parts[0];
            $ingredient->quantity = $parts[1] ?? null;
            $ingredient->unit = $parts[2] ?? null;
        }

        return view('recipes.edit')->with(['recipe' => $recipe, 'categories' => $categories]);
    }

    public function update(RecipeRequest $request, Recipe $recipe)
    {

        $this->authorize('update', $recipe);

        // レシピ本体の更新
        $recipeData = $request->input('recipe');
        $recipe->fill($recipeData);

        // レシピ画像の更新
        if ($request->hasFile('recipe_image')) {
            $recipeImage = $request->file('recipe_image');
            $recipeImageSaveAsName = time() . "-" . $recipeImage->getClientOriginalName();
            $upload_path = 'recipe_images/';
            $recipe_image_path = $recipeImage->storeAs('public/recipe_images', $recipeImageSaveAsName);
            $recipe->image_path = asset(str_replace('public', 'storage', $recipe_image_path));
        }

        $recipe->save();

        // ステップの更新
        $stepData = $request->input('step', []);

        foreach ($stepData as $index => $data) {
            if (isset($data['id'])) {
                // 既存のステップの更新
                $step = Step::find($data['id']);
                if ($step) {
                    $step->fill($data);
                    // 画像のアップロード条件を追加
                    if ($request->hasFile('step.' . $index . '.image')) {
                        $stepImage = $request->file('step.' . $index . '.image');
                        $stepImageSaveAsName = time() . "-" . $stepImage->getClientOriginalName();
                        $step_image_path = $stepImage->storeAs('public/step_images', $stepImageSaveAsName);
                        $step->image_path = asset(str_replace('public', 'storage', $step_image_path));
                    }
                    $step->save();
                }
            } else {
                // 新規のステップの追加
                $newStep = $recipe->steps()->create($data);
                // 画像のアップロード条件を追加
                if ($request->hasFile('step.' . $index . '.image')) {
                    $stepImage = $request->file('step.' . $index . '.image');
                    $stepImageSaveAsName = time() . "-" . $stepImage->getClientOriginalName();
                    $step_image_path = $stepImage->storeAs('public/step_images', $stepImageSaveAsName);
                    $newStep->image_path = asset(str_replace('public', 'storage', $step_image_path));
                }
                $newStep->save();
            }
        }


        // ステップの削除
        $deleteStepIds = $request->input('delete_steps', []);
        Step::destroy($deleteStepIds);

        // 材料の取得
        $ingredientIds = $request->input('ingredient_ids', []);
        $ingredientNames = $request->input('ingredient_names', []);
        $ingredientQuantities = $request->input('ingredient_quantities', []);
        $ingredientUnits = $request->input('ingredient_units', []);

        $existingIngredientIds = $recipe->ingredients->pluck('id')->toArray();

        foreach ($ingredientNames as $index => $name) {
            $quantity = $ingredientQuantities[$index] ?? null;
            $unit = $ingredientUnits[$index] ?? null;

            // ここで材料名、量、単位を一つの文字列に結合
            $formattedIngredient = $name;
            if ($quantity && $unit) {
                $formattedIngredient .= ' ' . $quantity . ' ' . $unit;
            } elseif ($quantity) {
                $formattedIngredient .= ' ' . $quantity;
            }

            // idがある場合は更新し、無い場合は新規作成
            if (isset($ingredientIds[$index]) && in_array($ingredientIds[$index], $existingIngredientIds)) {
                $ingredient = Ingredient::find($ingredientIds[$index]);
                if ($ingredient) {
                    $ingredient->update(['name' => $formattedIngredient]);

                    // 既存のIDからこのIDを削除
                    $key = array_search($ingredientIds[$index], $existingIngredientIds);
                    if ($key !== false) {
                        unset($existingIngredientIds[$key]);
                    }
                }
            } else {
                $recipe->ingredients()->create(['name' => $formattedIngredient]);
            }
        }

        // この時点で$existingIngredientIdsには、編集画面には表示されていない材料のIDのみが残っています。
        // これを使って、不要な材料を削除します。
        Ingredient::destroy($existingIngredientIds);

        // カテゴリーの更新
        $categoryData = $request->input('category_id');
        $recipe->categories()->sync($categoryData);

        // タグの更新も同様に

        return redirect()->route('recipes.show', ['recipe' => $recipe]);
    }

    public function create(Category $category)
    {
        return view('recipes.create')->with(['categories' => $category->get()]);
    }

    //レシピの削除
    public function destroy(Recipe $recipe)
    {
        $recipe->delete();

        return redirect('/recipes');
    }

    //レシピとカテゴリーの保存
    public function store(RecipeRequest $request, Recipe $recipe)
    {

        Log::info('Received request data:', $request->all());

        //レシピデータの取得
        $input_recipe = $request['recipe'];

        if ($request->hasFile('recipe_image')) {
            $recipeImage = $request->file('recipe_image');
            $recipeImageSaveAsName = time() . "-" . $recipeImage->getClientOriginalName();
            $upload_path = 'recipe_images/';
            $recipe_image_path = $recipeImage->storeAs('public/recipe_images', $recipeImageSaveAsName);
            $recipe->image_path = asset(str_replace('public', 'storage', $recipe_image_path));
        }

        //レシピの保存とカテゴリーIDのリレーション
        $recipe->fill($input_recipe)->save();
        $recipe->user_id = auth()->id();
        $recipe->save();
        $recipe->categories()->attach($request->category_id);

        //レシピとタグのリレーション
        $tags = array_map('trim', explode('#', $request->tag_id));
        foreach ($tags as $tag) {
            if (!empty($tag)) {
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
        $allFiles = $request->allFiles();
        $step_images = isset($allFiles['step_image']) ? $allFiles['step_image'] : null;

        for ($i = 0; $i < count($step_numbers); $i++) {
            $step = new Step;
            $step->recipe_id = $recipe->id;
            $step->step_number = $step_numbers[$i];
            $step->description = $step_descriptions[$i];

            // ステップ画像がアップロードされた場合、画像を保存します。
            if ($step_images !== null && isset($step_images[$i])) {
                $stepImage = $step_images[$i];
                $stepImageSaveAsName = time() . "-" . $stepImage->getClientOriginalName();
                $upload_path = 'step_images/';
                $step_image_path = $stepImage->storeAs('public/step_images', $stepImageSaveAsName);
                $step->image_path = asset(str_replace('public', 'storage', $step_image_path));
            }

            $step->save();
        }

        return redirect('/recipes');
    }

    public function myRecipes()
    {
        $user = auth()->user();
        $recipes = $user->recipes;

        return view('user.index', compact('recipes'));
    }
}
