<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>RECIPES</title>
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
            <h3 class="categories">
            @foreach($recipe->categories as $category)   
               {{ $category->category_name }}
            @endforeach
            </h3>
            <p class='body'>{{ $recipe->body }}</p>
         </div>
        @endforeach 
        </div>
    </body>
</html>

