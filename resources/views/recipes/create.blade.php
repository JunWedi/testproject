<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Register Recipe</title>
    </head>
    <body>
        <h1>Register Recipe</h1>
        <form action="/recipes" method="POST">
            @csrf
            <div class="title">
                <h2>Name of food</h2>
                <input type="text" name="recipe[title]" placeholder="料理名"/>
            </div>
            <div class="body">
                <h2>Body</h2>
                <textarea name="recipe[body]" placeholder="鶏肉、豚肉、牛肉etc"></textarea>
            </div>
            <input type="submit" value="store"/>
        </form>
        <div class="footer">
            <a href="/">戻る</a>
        </div>
    </body>
</html>