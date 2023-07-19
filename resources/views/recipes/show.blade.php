<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Recipe</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <h1 class="title">
            {{ $recipe->title }}
        </h1>
        <div class="content">
            <div class="content__recipe">
                <h3>本文</h3>
                <p>{{ $recipe->body }}</p>    
            </div>
        </div>
        <div class="edit"><a href="/recipes/{{ $recipe->id }}/edit">編集</a></div>
        <div class="footer">
            <a href="/">戻る</a>
        </div>
    </body>
</html>