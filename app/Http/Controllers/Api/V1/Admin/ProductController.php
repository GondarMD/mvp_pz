<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request) {
        $products = Product::with('category')->get();
        if ($request->wantsJson()) {
            return $products;
        }
        return Inertia::render('Admin/Products/Index', [
            'products' => $products
        ]);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'customization_schema' => 'nullable|array',
        ]);
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
