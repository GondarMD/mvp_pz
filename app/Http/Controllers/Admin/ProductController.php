<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;

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

    public function store(StoreProductRequest $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'is_digital' => 'boolean',
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'base_image_url' => 'nullable|url',
            'thumbnail_image_url' => 'nullable|url',
            'product_video_url' => 'nullable|url',
            'product_pdf_url' => 'nullable|url',
            'product_3d_model_url' => 'nullable|url',
            'product_3d_model_thumbnail_url' => 'nullable|url',
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
