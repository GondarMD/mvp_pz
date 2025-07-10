<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Product;
use App\Models\Category;
use App\Http\Requests\StoreProductRequest;

class ProductController extends Controller
{
    public function index(Request $request) {
        $products = Product::with('category')->get();
        $categories = Category::all()->load('subcategories');

        if ($request->wantsJson()) {
            return ['products' => '$products', 'categories' => '$categories'];
        }
        return Inertia::render('Admin/ProductManagement', [
            'products' => $products,
            'categories' => $categories
        ]);
    }

    public function store(StoreProductRequest $request) {
        $validated = $request->validated();

        $product = Product::create($validated);
        return $request->wantsJson()
            ? $product
            : redirect()->back()->with('success', 'Product created');
    }

    public function update(Request $request, Product $product) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'customization_schema' => 'nullable|array',
        ]);
        $product->update($validated);
        return $request->wantsJson()
            ? $product
            : redirect()->back()->with('success', 'Product updated');
    }

    public function destroy(Request $request, Product $product) {
        $product->delete();
        return $request->wantsJson()
            ? response()->noContent()
            : redirect()->back()->with('success', 'Product deleted');
    }
}
