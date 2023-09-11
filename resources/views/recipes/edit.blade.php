<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>レシピ編集</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<x-app-layout>
    <x-slot name="header">
        @include('layouts.header')
    </x-slot>

    <body>

        <h1 class="text-center my-4">編集画面</h1>
        <!-- 編集フォーム -->
        <div class="flex justify-center items-center min-h-screen">
            <div class="bg-yellow-400 p-4 rounded-lg shadow-lg">
                <form action="/recipes/{{ $recipe->id }}" method="POST" enctype="multipart/form-data" class="container mx-auto">
                    @csrf
                    @method('PUT')

                    <!-- Tabs navigation -->
                    <ul class="nav nav-tabs" id="recipeTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="basic-tab" data-bs-toggle="tab" href="#basicInfo" role="tab">基本情報</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="steps-tab" data-bs-toggle="tab" href="#stepsInfo" role="tab">作り方 & 材料</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="tags-tab" data-bs-toggle="tab" href="#tagsInfo" role="tab">カテゴリ & ハッシュタグ</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="recipeTabsContent">
                        <div class="tab-pane fade show active" id="basicInfo" role="tabpanel">
                            <div class="block text-sm font-medium text-neutral-600 mt-5">
                                <label for="recipe_title" class="block text-bold mb-2">料理名</label>
                                <input type="text" id="recipe_title" name="recipe[title]" value="{{ $recipe->title }}" placeholder="料理名" class="form-control" />
                            </div>

                            <!-- 本文 -->
                            <div class="block text-sm font-medium text-neutral-600 mt-5">
                                <h2>紹介文</h2>
                                <textarea name="recipe[body]" placeholder="紹介文">{{ $recipe->body }}</textarea>
                            </div>

                            <!-- レシピ画像 -->
                            <div class="recipe_image mt-5">
                                <h2>レシピ写真</h2>
                                <img src="{{ asset($recipe->image_path) }}" class="img-fluid rounded recipe-image" alt="Recipe Image">
                                <input type="file" name="recipe_image">
                            </div>

                        </div>

                        <div class="tab-pane fade" id="stepsInfo" role="tabpanel">
                            <!-- ステップの編集 -->
                            <div class="mt-5" id="steps">
                                <h2>作り方</h2>
                                @foreach($recipe->steps as $index => $step)
                                <div class="step">
                                    <input type="hidden" name="step[{{ $index }}][id]" value="{{ $step->id }}">
                                    <input class="block text-sm font-medium text-neutral-600 mt-3" type="number" name="step[{{ $index }}][step_number]" value="{{ $step->step_number }}" placeholder="ステップ番号">
                                    <textarea class="block text-sm font-medium text-neutral-600 mt-3" name="step[{{ $index }}][description]" placeholder="作り方">{{ $step->description }}</textarea>
                                    <input class="block text-sm font-medium text-neutral-600 mt-3" type="file" name="step[{{ $index }}][image]">
                                    <img src="{{ $step->image_path }}" class="img-fluid rounded step-image" alt="step image">
                                    <button class="btn btn-info mt-3" type="button" onclick="removeStep(this, {{ $step->id }})">削除</button>
                                </div>
                                @endforeach
                            </div>

                            <!-- 削除されたステップのIDを保存するフィールド -->
                            <input type="hidden" name="delete_steps" id="delete_steps" value="">

                            <button class="btn btn-info mt-3" type="button" onclick="addStep()">ステップを追加</button>
                            <!-- 材料の編集 -->
                            <div class="mt-5" id="ingredients">
                                <h2>材料</h2>
                                @foreach($recipe->ingredients as $ingredient)
                                <div class="ingredient">
                                    <input class="text-sm font-medium text-neutral-600 mt-3" type="text" name="ingredient_names[]" value="{{ $ingredient->name }}" placeholder="材料名">
                                    <input class="text-sm font-medium text-neutral-600 mt-3" type="text" name="ingredient_quantities[]" value="{{ $ingredient->quantity }}" placeholder="量">
                                    <input class="text-sm font-medium text-neutral-600 mt-3" type="text" name="ingredient_units[]" value="{{ $ingredient->unit }}" placeholder="単位">
                                    <button class="btn btn-info" type="button" onclick="removeIngredient(this)">削除</button>
                                </div>
                                @endforeach
                            </div>

                            <button class="btn btn-info mt-3" type="button" onclick="addIngredient()">材料を追加</button>

                        </div>

                        <div class="tab-pane fade" id="tagsInfo" role="tabpanel">
                            <!-- カテゴリーの編集 -->
                            <div class="category mt-5">
                                <h2>カテゴリー</h2>
                                <select name="category_id[]" multiple>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @if($recipe->categories->contains('id', $category->id)) selected @endif>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>


                            <!-- タグの編集 -->
                            <h2 class="mt-5">タグ</h2>
                            <div class="tag">
                                <textarea name="tags" placeholder="#ちょい辛い#一度は食べたいetc">@foreach($recipe->tags as $tag) #{{ $tag->name }} @endforeach</textarea>
                            </div>


                        </div>

                        <div class="d-grid gap-2 mt-5">
                            <input type="submit" class="btn btn-info" value="更新" /> <!-- ボタンのテキストを更新アクションに合わせて変更 -->
                        </div>

                </form>

                <!-- 削除フォーム -->
                <div class="d-grid gap-2 mt-5">
                    <form action="/recipes/{{ $recipe->id }}" method="POST" id="delete_form">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" onclick="deleteRecipe({{ $recipe->id }})">削除</button>
                    </form>
                </div>

                <div class="d-grid gap-2 mt-5">
                    <a href="/" class="btn btn-info">戻る</a>
                </div>



                <script>
                    let stepCounter = {{ $recipe -> steps -> count() }};
                    let maxStepNumber = {{ $recipe -> steps -> max('step_number') ?? 0 }};

                    function addIngredient() {
                        var div = document.createElement('div');
                        div.className = 'ingredient';
                        div.innerHTML = `
                            <input class="text-sm font-medium text-neutral-600 mt-3" type="text" name="ingredient_names[]" placeholder="材料名">
                            <input class="text-sm font-medium text-neutral-600 mt-3" type="text" name="ingredient_quantities[]" placeholder="量">
                            <input class="text-sm font-medium text-neutral-600 mt-3" type="text" name="ingredient_units[]" placeholder="単位">
                            <button class="btn btn-info" type="button" onclick="removeIngredient(this)">削除</button>
                        `;
                        document.getElementById('ingredients').appendChild(div);
                    }

                    function removeIngredient(button) {
                        var ingredient = button.parentNode;
                        ingredient.parentNode.removeChild(ingredient);
                    }

                    function addStep() {
                        var div = document.createElement('div');
                        div.className = 'step';
                        div.innerHTML = `
                            <input type="hidden" name="step[${stepCounter}][id]">
                            <input class="block text-sm font-medium text-neutral-600 mt-3" type="number" name="step[${stepCounter}][step_number]" value="${++maxStepNumber}" placeholder="ステップ番号">
                            <textarea class="block text-sm font-medium text-neutral-600 mt-3" name="step[${stepCounter}][description]" placeholder="ステップの説明"></textarea>
                            <input class="block text-sm font-medium text-neutral-600 mt-3" type="file" name="step[${stepCounter}][image]">
                            <img src="" class="img-fluid rounded step-image" alt="step image">
                            <button class="btn btn-info mt-3" type="button" onclick="removeStep(this)">削除</button>
                        `;
                        document.getElementById('steps').appendChild(div);
                        stepCounter++;
                    }

                    function removeStep(button, stepId) {
                        var step = button.parentNode;
                        if (stepId) {
                            var deleteSteps = document.getElementById('delete_steps');
                            var existingValues = deleteSteps.value.split(',');
                            if (!existingValues.includes(stepId.toString())) { // toStringを使用して数値を文字列に変換
                                deleteSteps.value += stepId + ',';
                            }
                        }
                        step.parentNode.removeChild(step);

                        recalculateStepNumbers();
                    }

                    function recalculateStepNumbers() {
                        const steps = document.querySelectorAll('#steps .step input[type="number"]');
                        for (let i = 0; i < steps.length; i++) {
                            steps[i].value = i + 1;
                        }
                        maxStepNumber = steps.length;
                    }
                </script>

                <script>
                    function deleteRecipe(id) {
                        'use strict'

                        if (confirm('削除すると復元できません。\n本当に削除しますか？')) {
                            document.getElementById('delete_form').submit();
                        }
                    }
                </script>
            </div>
        </div>
    </body>
</x-app-layout>

</html>