<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Blog</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <h1>RECIPIES</h1>
        <a href='/recipes/create'>投稿</a>
        <div class='recipes'>
        @foreach ($recipes as $recipe)
         <div class='recipe'>
            <h2 class='title'>
                <a href="/recipes/{{ $recipe->id }}">{{ $recipe->title }}</a>
            </h2>
            <p class='body'>{{ $recipe->body }}</p>
         </div>
        @endforeach 
        </div>
    </body>
</html>

