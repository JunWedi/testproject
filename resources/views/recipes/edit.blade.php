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
        <form action="/recipes/{{ $recipe->id }}" method="POST">
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
    </div>
</html>