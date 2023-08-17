<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>レシピ登録</title>
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <x-app-layout>
    <x-slot name="header">
        @include('layouts.header')
    </x-slot>

    <body>
    <div class="flex justify-center items-center min-h-screen">
        <div class="bg-yellow-400 p-4 rounded-lg shadow-lg">
        <form action="/recipes" method="POST" enctype="multipart/form-data">
        @csrf

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
                <input type="text" name="recipe[title]" placeholder="料理名" value="{{ old('recipe.title') }}" />
                <p class="title__error" style="color:red">{{ $errors->first('recipe.body') }}</p>
            </div>
            <div class="block text-sm font-medium text-neutral-600 mt-5">
                <textarea name="recipe[body]" placeholder="紹介文">{{ old('recipe.title') }}</textarea>
                <p class="title__error" style="color:red">{{ $errors->first('recipe.body') }}</p>
            </div>

            
            <header class="mt-5 flex flex-col items-center justify-center py-12 text-base transition duration-500 ease-in-out transform bg-white border border-dashed rounded-lg text-blueGray-500 focus:border-blue-500 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2">
                <p class="flex flex-wrap justify-center mb-3 text-base leading-7 text-blueGray-500">
                <span>料理の写真</span></p>
                <input type="file" name="recipe_image">
            </header>
    </div>

    <div class="tab-pane fade" id="stepsInfo" role="tabpanel">
    <div id="steps">
                <div class="step mt-5">    
                 <input class="block text-sm font-medium text-neutral-600 mt-3" type="number" name="step_numbers[]" placeholder="ステップ番号">
                 <textarea class="block text-sm font-medium text-neutral-600 mt-3" name="step_descriptions[]" placeholder="作り方"></textarea>
                 <input class="flex flex-wrap justify-center mb-3 text-base leading-7 text-blueGray-500 mt-3" type="file" name="step_image[]">
                 <button class="btn btn-info mt-3" type="button" onclick="removeStep(this)">削除</button>
                </div>
            </div>

            <button class="btn btn-info mt-3" type="button" onclick="addStep()">ステップを追加</button>

            <div id="ingredients">
                <div class="ingredient mt-5">
                    <input class=" text-sm font-medium text-neutral-600 mt-3" type="text" name="ingredient_names[]" placeholder="材料名">
                    <input class=" text-sm font-medium text-neutral-600 mt-3" type="text" name="ingredient_quantities[]" placeholder="量">
                    <input class=" text-sm font-medium text-neutral-600 mt-3" type="text" name="ingredient_units[]" placeholder="単位">
                    <button class="btn btn-info" type="button" onclick="removeIngredient(this)">削除</button>
                </div>
            </div>

            <button class="btn btn-info mt-3" type="button" onclick="addIngredient()">材料を追加</button>
    </div>
    <div class="tab-pane fade" id="tagsInfo" role="tabpanel">
    <div class="category">
                <select class="mt-5" name="category_id">
                 @foreach($categories as $category)
                   <option value="{{ $category->id }}">
                    {{ $category->name }}
                   </option>
                 @endforeach
                </select>
            </div>
            <div class="block text-sm font-medium text-neutral-600 mt-5">
                <textarea name="tag_id" placeholder="#ちょい辛い#一度は食べたいetc"></textarea>
            </div>
    </div>
</div>

            

           <div class="d-grid gap-2 mt-5">
             <input type="submit" class="btn btn-info" value="登録"/>
           </div>

            
           </form>


    
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>


        <script>

            function addIngredient() {
                var div = document.createElement('div');
                div.className = 'ingredient';
                div.innerHTML = `
                    <input class=" text-sm font-medium text-neutral-600 mt-3" type="text" name="ingredient_names[]" placeholder="材料名">
                    <input class=" text-sm font-medium text-neutral-600 mt-3" type="text" name="ingredient_quantities[]" placeholder="量">
                    <input class=" text-sm font-medium text-neutral-600 mt-3" type="text" name="ingredient_units[]" placeholder="単位">
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
                    <input class="block text-sm font-medium text-neutral-600 mt-3" type="number" name="step_numbers[]" placeholder="ステップ番号">
                    <textarea class="block text-sm font-medium text-neutral-600 mt-3" name="step_descriptions[]" placeholder="作り方"></textarea>
                    <input class="flex flex-wrap justify-center mb-3 text-base leading-7 text-blueGray-500 mt-3" type="file" name="step_image[]">
                    <button class="btn btn-info mt-3" type="button" onclick="removeStep(this)">削除</button>
                `;
                document.getElementById('steps').appendChild(div);
            }

            function removeStep(button) {
                var step = button.parentNode;
                step.parentNode.removeChild(step);
            }

            
        </script>
        </div>
    </div>
    </body>
</x-app-layout>
</html>