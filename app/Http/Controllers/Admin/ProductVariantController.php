<!-- 
    This controller is responsible for managing product variants in the admin panel.
    It allows for creating, updating, and deleting product variants.
    It is not used for displaying product variants to users - that is handled by the Web\ProductVariantController.
1
-->
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ProductVariant;
use App\Models\ProductVariantOption;
use App\Models\ProductVariantOptionValue;

class ProductVariantController extends Controller
{


    /**
     * Store a newly created ProductVariant object in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:255',
            'variant_price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'barcode' => 'nullable|string|max:255',
            'image_url' => 'nullable|url|max:255',
            'thumbnail_image_url' => 'nullable|url|max:255',
            'variant_image_urls' => 'nullable|array',
            'variant_image_urls.*' => 'nullable|url|max:255',
            'video_url' => 'nullable|url|max:255',
            'pdf_url' => 'nullable|url|max:255',
            '3d_model_url' => 'nullable|url|max:255',
            '3d_model_thumbnail_url' => 'nullable|url|max:255',
            'is_digital' => 'boolean',
            'is_default' => 'boolean',
            'is_active' => 'boolean'
        ]);

        // Handle image uploads for image fields if files are present in the request
        $imageFields = [
            'image_url',
            'thumbnail_image_url',
            'variant_image_urls',
            '3d_model_thumbnail_url'
        ];

        foreach ($imageFields as $field) {
            if ($field === 'variant_image_urls' && $request->hasFile($field)) {
                $uploadedUrls = [];
                foreach ($request->file($field) as $file) {
                    $uploadedUrls[] = $file->store('product_variants', 'public');
                }
                $validatedData[$field] = $uploadedUrls;
            } elseif ($request->hasFile($field)) {
                $validatedData[$field] = $request->file($field)->store('product_variants', 'public');
            }
        }


        $productVariant = ProductVariant::create($validatedData);

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Product variant created successfully.',
                'data' => $productVariant,
            ]);
        }

        return back()->with([
            'status' => 'success',
            'message' => 'Product variant created successfully.',
            'data' => $productVariant,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $productVariant = ProductVariant::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:255',
            'variant_price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'barcode' => 'nullable|string|max:255',
            'image_url' => 'nullable|url|max:255',
            'thumbnail_image_url' => 'nullable|url|max:255',
            'variant_image_urls' => 'nullable|array',
            'variant_image_urls.*' => 'nullable|url|max:255',
            'video_url' => 'nullable|url|max:255',
            'pdf_url' => 'nullable|url|max:255',
            '3d_model_url' => 'nullable|url|max:255',
            '3d_model_thumbnail_url' => 'nullable|url|max:255',
            'is_digital' => 'boolean',
            'is_default' => 'boolean',
            'is_active' => 'boolean'
        ]);

        // Handle image uploads for image fields if files are present in the request
        $imageFields = [
            'image_url',
            'thumbnail_image_url',
            'variant_image_urls',
            '3d_model_thumbnail_url'
        ];

        foreach ($imageFields as $field) {
            if ($field === 'variant_image_urls' && $request->hasFile($field)) {
                $uploadedUrls = [];
                foreach ($request->file($field) as $file) {
                    $uploadedUrls[] = $file->store('product_variants', 'public');
                }
                $validatedData[$field] = $uploadedUrls;
            } elseif ($request->hasFile($field)) {
                $validatedData[$field] = $request->file($field)->store('product_variants', 'public');
            }
        }

        $productVariant->update($validatedData);

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Product variant updated successfully.',
                'data' => $productVariant,
            ]);
        }

        return back()->with([
            'status' => 'success',
            'message' => 'Product variant updated successfully.',
            'data' => $productVariant,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $productVariant = ProductVariant::findOrFail($id);
        $productVariant->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Product variant deleted successfully.',
            ]);
        }

        return back()->with([
            'status' => 'success',
            'message' => 'Product variant deleted successfully.',
        ]);
    }
}
