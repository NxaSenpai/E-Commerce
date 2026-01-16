<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function getCategories()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    public function createCategory(Request $request)
    {
        abort_unless(auth()->user()->can('categories.create'), 403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $category = Category::create($validated);
        return response()->json($category, 201);
    }

    public function getCategory($categoryId)
    {
        $category = Category::find($categoryId);
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }
        $this->authorize('view', $category);
        return response()->json($category);
    }

    public function updateCategory(Request $request, $categoryId)
    {
        abort_unless(auth()->user()->can('categories.update'), 403);

        $category = Category::find($categoryId);
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $category->update($validated);
        return response()->json($category);
    }

    public function deleteCategory($categoryId)
    {
        abort_unless(auth()->user()->can('categories.delete'), 403);

        $category = Category::find($categoryId);
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }
        $category->delete();
        return response()->json(['message' => 'Category deleted']);
    }

    public function updateStatus(Request $request, $categoryId)
    {
        $category = Category::find($categoryId);
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }
        $this->authorize('updateStatus', $category);
    }
}
