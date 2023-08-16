<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>RECIPES</title>
        <!-- Fonts -->
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
    <x-app-layout>
    <x-slot name="header">
        @include('layouts.header')
    </x-slot>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        @foreach ($recipes as $recipe)
                        <div class="col-lg-4">
                            <div class="card mt-4">
                                <div class="card-body">
                                    <h4 class="card-recipe_image">
                                    <img src="{{ asset($recipe->image_path) }}" alt="Recipe Image" class="img-fluid">
                                    </h4>
                                    <h5 class="card-title">
                                        <a href="/recipes/{{ $recipe->id }}">{{ $recipe->title }}</a>
                                    </h5>
                                    <h6 class="card-subtitle mb-2 text-muted categories">
                                    @foreach($recipe->categories as $category)
                                        {{ $category->category_name }}
                                    @endforeach
                                    </h6>
                                    <p class="card-text">{{ $recipe->body }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</x-app-layout>
</html>

