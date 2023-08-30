<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Category;

class TagController extends Controller
{
    public function index(Tag $tag)
    {
        $categories = Category::all();
        return view('tags.index')->with(['recipes' => $tag->getByTag(), 'categories' => $categories]);
    }
}
