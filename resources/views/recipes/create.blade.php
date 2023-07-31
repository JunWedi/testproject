<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Register Recipe</title>
    </head>
    <body>
        <h1>Register Recipe</h1>
        <form action="/recipes" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="title">
                <h2>Name of food</h2>
                <input type="text" name="recipe[title]" placeholder="料理名"/>
            </div>
            <div class="body">
                <h2>Body</h2>
                <textarea name="recipe[body]" placeholder="紹介文"></textarea>
            </div>
            <div class="recipe_image">
               <h2>Recipe Image</h2>
                   <input type="file" name="recipe_image">
            </div>
            <div id="steps">
                <h2>Step</h2>
                <div class="step">    
                 <input type="number" name="step_numbers[]" placeholder="ステップ番号">
                 <textarea name="step_descriptions[]" placeholder="ステップの説明"></textarea>
                 <input type="file" name="step_image[]">
                 <button type="button" onclick="removeIngredient(this)">削除</button>
                </div>
            </div>

            <button type="button" onclick="addStep()">ステップを追加</button>

            <div id="ingredients">
                <h2>Ingredients</h2>
                <div class="ingredient">
                    <input type="text" name="ingredient_names[]" placeholder="材料名">
                    <input type="text" name="ingredient_quantities[]" placeholder="量">
                    <input type="text" name="ingredient_units[]" placeholder="単位">
                    <button type="button" onclick="removeIngredient(this)">削除</button>
                </div>
            </div>

            <button type="button" onclick="addIngredient()">材料を追加</button>
            <div class="category">
              <h2>Category</h2>
                <select name="category_id">
                 @foreach($categories as $category)
                   <option value="{{ $category->id }}">
                    {{ $category->name }}
                   </option>
                 @endforeach
                </select>
            </div>
            <h2>Tag</h2>
            <div class="tag">
                <textarea name="tag_id" placeholder="#ちょい辛い#一度は食べたいetc"></textarea>
            </div>
            <input type="submit" value="store"/>
        </form>
        <div class="footer">
            <a href="/">戻る</a>
        </div>
    </body>
</html>

<script>
function addIngredient() {
    var div = document.createElement('div');
    div.className = 'ingredient';
    div.innerHTML = '<input type="text" name="ingredient_names[]" placeholder="材料名"><input type="text" name="ingredient_quantities[]" placeholder="量"><input type="text" name="ingredient_units[]" placeholder="単位"><button type="button" onclick="removeIngredient(this)">削除</button>';
    document.getElementById('ingredients').appendChild(div);
}

function removeIngredient(button) {
    var ingredient = button.parentNode;
    ingredient.parentNode.removeChild(ingredient);
}

function addStep() {
    var div = document.createElement('div');
    div.className = 'step';
    div.innerHTML = '<input type="number" name="step_numbers[]" placeholder="ステップ番号"><textarea name="step_descriptions[]" placeholder="ステップの説明"></textarea><input type="file" name="step_image"><button type="button" onclick="removeStep(this)">削除</button>';
    document.getElementById('steps').appendChild(div);
}

function removeStep(button) {
    var step = button.parentNode;
    step.parentNode.removeChild(step);
}

</script>