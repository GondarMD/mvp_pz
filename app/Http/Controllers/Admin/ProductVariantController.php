<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\ProductVariant;

class ProductVariantController extends Controller
{
    public function variantOptions(Product $product)
    {
        return $product->variantOptions()->with('values')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'size' => 'required|string',
            'design_image' => 'nullable|image|max:5120',
            'options' => 'required|array',
            'options.*' => 'required|exists:product_variant_option_values,id',
        ]);

        $path = null;
        if ($request->hasFile('design_image')) {
            $path = $request->file('design_image')->store('designs', 'public');
        }

        $variant = ProductVariant::create([
            'product_id' => $validated['product_id'],
            'size' => $validated['size'],
            'design_image_path' => $path,
        ]);

        $variant->optionValues()->sync($validated['options']);

        if ($request->wantsJson()) {
            return response()->json($variant->load('optionValues'), 201);
        }

        return back()->with([
            'status' => 'success',
            'message' => 'Product variant created successfully.',
            'data' => $variant->load('optionValues')
        ]);
    }
}
