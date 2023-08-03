<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Edit Recipe</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
    <h1 class="title">編集画面</h1>
    <div class="content">
        <!-- 編集フォーム -->
        <form action="/recipes/{{ $recipe->id }}" method="POST" id="edit_form">
            @csrf
            @method('PUT')
            <div class='content__title'>
                <h2>タイトル</h2>
                <input type='text' name='recipe[title]' value="{{ $recipe->title }}">
            </div>
            <div class='content__body'>
                <h2>本文</h2>
                <input type='text' name='recipe[body]' value="{{ $recipe->body }}">
            </div>
            <input type="submit" value="保存">
        </form>
        <!-- 削除フォーム -->
        <form action="/recipes/{{ $recipe->id }}" method="POST" id="delete_form">
            @csrf
            @method('DELETE')
            <button type="button" onclick="deleteRecipe({{ $recipe->id }})">delete</button> 
        </form>
    </div>
</html>

<script>
    function deleteRecipe(id) {
        'use strict'

        if (confirm('削除すると復元できません。\n本当に削除しますか？')) {
            document.getElementById('delete_form').submit();
        }
    }
</script>
