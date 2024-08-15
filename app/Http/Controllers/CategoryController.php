<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use function Laravel\Prompts\alert;

class CategoryController extends Controller
{
    //
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:categories,name',
        ]);

        $category = Category::create($data);

        return response()->json(['success' => true, 'category' => $category]);
    }
    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $categoryName = $request->input('name');

        // Add the new category to the database
        $category = new Category();
        $category->name = $categoryName;
        $category->save();

        return response()->json(['success' => true]);
    }
}
