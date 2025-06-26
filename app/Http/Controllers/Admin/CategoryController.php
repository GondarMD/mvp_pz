<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Category;

class CategoryController extends Controller
{
    public function index(Request $request) {
        $categories = Category::all()->load('subcategories');

        if ($request->wantsJson()) {
            return $categories;
        }
        return Inertia::render('Admin/CategoryManagement', [
            'categories' => $categories
        ]);
    }

    public function store(Request $request) {
        $request->validate(['name' => 'required|string|max:255']);
        $category = Category::create($request->only('name'));
        return $request->wantsJson()
            ? $category
            : redirect()->back()->with('success', 'Category created');
    }

    public function edit(Request $request, Category $category) {
        if ($request->wantsJson()) {
            return $category;
        }
        return Inertia::render('Admin/Categories/EditCategory', [
            'category' => $category
        ]);
    }

    public function update(Request $request, Category $category) {
        $request->validate(['name' => 'required|string|max:255']);
        $category->update($request->only('name'));
        return $request->wantsJson()
            ? $category
            : redirect()->back()->with('success', 'Category updated');
    }

    public function destroy(Request $request, Category $category) {
        $category->delete();
        return $request->wantsJson()
            ? response()->noContent()
            : redirect()->back()->with('success', 'Category deleted');
    }
}
