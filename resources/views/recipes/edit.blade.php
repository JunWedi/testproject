<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Edit Recipe</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <x-app-layout>
    <x-slot name="header">
     AsiFoods
    </x-slot>
    
    <body>
    
        <h1>Edit Recipe</h1>
        <!-- 編集フォーム -->
        <form action="/recipes/{{ $recipe->id }}" method="POST" enctype="multipart/form-data">

            @csrf
            @method('PUT')


            <!-- タイトル -->
            <div class="title">
                <h2>Name of food</h2>
                <input type="text" name="recipe[title]" value="{{ $recipe->title }}" placeholder="料理名" />
            </div>

            <!-- 本文 -->
            <div class="body">
                <h2>Body</h2>
                <textarea name="recipe[body]" placeholder="紹介文">{{ $recipe->body }}</textarea>
            </div>

            <!-- レシピ画像 -->
            <div class="recipe_image">
                <h2>Recipe Image</h2>
                <img src="{{ asset($recipe->image_path) }}" class="img-fluid rounded recipe-image" alt="Recipe Image" >
                <input type="file" name="recipe_image">
            </div>

            <!-- ステップの編集 -->
            <div id="steps">
    <h2>Step</h2>
    @foreach($recipe->steps as $index => $step)
        <div class="step">
            <input type="hidden" name="step[{{ $index }}][id]" value="{{ $step->id }}">
            <input type="number" name="step[{{ $index }}][step_number]" value="{{ $step->step_number }}" placeholder="ステップ番号">
            <textarea name="step[{{ $index }}][description]" placeholder="ステップの説明">{{ $step->description }}</textarea>
            <input type="file" name="step[{{ $index }}][image]">
            <img src="{{ $step->image_path }}" class="img-fluid rounded step-image" alt="step image">
            <button type="button" onclick="removeStep(this, {{ $step->id }})">削除</button>
        </div>
    @endforeach
</div>

<!-- 削除されたステップのIDを保存するフィールド -->
<input type="hidden" name="delete_steps" id="delete_steps" value="">

<button type="button" onclick="addStep()">ステップを追加</button>
            <!-- 材料の編集 -->
            <div id="ingredients">
                <h2>Ingredients</h2>
                @foreach($recipe->ingredients as $ingredient)
                    <div class="ingredient">
                        <input type="text" name="ingredient_names[]" value="{{ $ingredient->name }}" placeholder="材料名">
                        <input type="text" name="ingredient_quantities[]" value="{{ $ingredient->quantity }}" placeholder="量">
                        <input type="text" name="ingredient_units[]" value="{{ $ingredient->unit }}" placeholder="単位">
                        <button type="button" onclick="removeIngredient(this)">削除</button>
                    </div>
                @endforeach
            </div>

            <button type="button" onclick="addIngredient()">材料を追加</button>

            <!-- カテゴリーの編集 -->
            <div class="category">
                <h2>Category</h2>
                <select name="category_id">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @if($category->id == $recipe->category_id) selected @endif>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- タグの編集 -->
            <h2>Tag</h2>
            <div class="tag">
                <textarea name="tag_id" placeholder="#ちょい辛い#一度は食べたいetc">{{ $recipe->tag_id }}</textarea>
            </div>

            <input type="submit" value="更新"/> <!-- ボタンのテキストを更新アクションに合わせて変更 -->
        </form>

        <!-- 削除フォーム -->
        <form action="/recipes/{{ $recipe->id }}" method="POST" id="delete_form">
            @csrf
            @method('DELETE')
            <button type="button" onclick="deleteRecipe({{ $recipe->id }})">delete</button> 
        </form>

        <div class="footer">
            <a href="/">戻る</a>
        </div>

        <script>
            let stepCounter = {{ $recipe->steps->count() }};

            function addIngredient() {
    var div = document.createElement('div');
    div.className = 'ingredient';
    div.innerHTML = `
        <input type="text" name="ingredient_names[]" placeholder="材料名">
        <input type="text" name="ingredient_quantities[]" placeholder="量">
        <input type="text" name="ingredient_units[]" placeholder="単位">
        <button type="button" onclick="removeIngredient(this)">削除</button>
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
        <input type="number" name="step[${stepCounter}][step_number]" placeholder="ステップ番号">
        <textarea name="step[${stepCounter}][description]" placeholder="ステップの説明"></textarea>
        <input type="file" name="step[${stepCounter}][image]">
        <img src="" class="img-fluid rounded step-image" alt="step image">
        <button type="button" onclick="removeStep(this)">削除</button>
    `;
    document.getElementById('steps').appendChild(div);
    stepCounter++;
}

function removeStep(button, stepId) {
    var step = button.parentNode;
    if (stepId) {
        var deleteSteps = document.getElementById('delete_steps');
        var existingValues = deleteSteps.value.split(',');
        if (!existingValues.includes(stepId.toString())) {  // toStringを使用して数値を文字列に変換
            deleteSteps.value += stepId + ',';
        }
    }
    step.parentNode.removeChild(step);
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
    </body>
    </x-app-layout>
</html>