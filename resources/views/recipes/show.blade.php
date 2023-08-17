<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Recipe</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<x-app-layout>
    <x-slot name="header">
        @include('layouts.header')
    </x-slot>

    <body class="bg-gray-100">
        <div class="container mx-auto my-5 p-5">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold">{{ $recipe->title }}</h1>
            </div>
            <div class="flex flex-wrap -mx-3">
                <div class="w-full lg:w-1/2 px-3">
                    <img src="{{ asset($recipe->image_path) }}" class="w-full rounded-md shadow-lg"
                        alt="Recipe Image">
                </div>
                <div class="w-full lg:w-1/2 px-3 mt-6 lg:mt-0">
                    <h3 class="text-2xl font-semibold mb-4">Ingredients</h3>
                    <ul>
                        @foreach($recipe->ingredients as $ingredient)
                        <li class="mb-2">{{ $ingredient->name }}</li>
                        @endforeach
                    </ul>

                    <div class="mt-8">
                        <h3 class="text-2xl font-semibold mb-4">Steps</h3>
                        @foreach($recipe->steps as $step)
                        <div class="my-5 flex items-start">
                            <div class="w-1/4">
                                <img src="{{$step->image_path}}" class="w-full rounded-md shadow-lg"
                                    alt="step image">
                            </div>
                            <div class="w-3/4 ml-4">
                                <h4 class="text-xl mb-2">Step {{$step->step_number}}</h4>
                                <p>{{$step->description}}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="mt-8 flex space-x-4">
                <a href="/recipes/{{ $recipe->id }}/edit"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-md">編集</a>
                <a href="/" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-md">戻る</a>
            </div>
        </div>
    </body>
</x-app-layout>

</html>
