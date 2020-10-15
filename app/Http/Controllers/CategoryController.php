<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    public function show($name)
    {
        $categories = Category::where('name', 'like', $name.'%')->get();
        return response()->json($categories);
    }
}
