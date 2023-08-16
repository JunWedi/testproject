<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Recipe</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .recipe-image {
            height: 300px;
            object-fit: cover;
        }
        .step-image {
            height: 150px;
            object-fit: cover;
        }
    </style>
     @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<x-app-layout>
    <x-slot name="header">
        @include('layouts.header')
    </x-slot>
<body>
    <div class="container my-5">
        <div class="text-center">
            <h1 class="mb-4">{{ $recipe->title }}</h1>
            <img src="{{ asset($recipe->image_path) }}" class="img-fluid rounded recipe-image" alt="Recipe Image" >
        </div>
        <div class="mt-5">
            <h3>本文</h3>
            <p class="lead">{{ $recipe->body }}</p>    
        </div>
        <div class="mt-5">
            <h3>Ingredients</h3>
            @foreach($recipe->ingredients as $ingredient)
              <p>{{ $ingredient->name }}</p>
            @endforeach
        </div>
        <div class="mt-5">
            <h3>Steps</h3>
            @foreach($recipe->steps as $step)
              <div class="my-3 row">
                <div class="col-3">
                  <img src="{{$step->image_path}}" class="img-fluid rounded step-image" alt="step image">
                </div>
                <div class="col-9">
                  <h4>Step {{$step->step_number}}</h4>
                  <p>{{$step->description}}</p>
                </div>
              </div>
            @endforeach
        </div>
        <div class="my-4">
            <a href="/recipes/{{ $recipe->id }}/edit" class="btn btn-primary">編集</a>
        </div>
        <div class="mt-5">
            <a href="/" class="btn btn-secondary">戻る</a>
        </div>
    </div>
</body>
    </x-app-layout>
</html>
