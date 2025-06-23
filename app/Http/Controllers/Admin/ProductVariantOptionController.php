 <!-- 
    Admin-only controller for managing product variant options.
    This controller is used to create, update, and delete product variant options.
    It is not used for displaying product variant options to users. 
-->

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ProductVariantOption;

class ProductVariantOptionController extends Controller
{
      /**
     * Store a newly created ProductVariantOption in db.
     * This is an admin-only action, and is guarded by the 'admin' middleware.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'attribute' => 'required|string|max:255',
            'label' => 'required|string|max:255',
            'option_values' => 'sometimes|array',
            'option_values.*' => 'string|max:255', // Validate each option value as a string with a maximum length
        ]);

        $productVariantOption = ProductVariantOption::create($validatedData);

        // If option values are provided, create them for the product variant option
        // This assumes that the option values are provided as an array of objects with 'label'
        // and 'value' properties, where 'label' is optional and defaults to the option
        // label if not provided.
        // The 'attribute' is set to the same value as the option's attribute,
        // which is used to group the option values under the same attribute.
        // This allows multiple option values for the same attribute (e.g. different frame dimensions for a given style of frame) 
        if ($request->has('option_values')) {
            $optionValues = $request->input('option_values');
            foreach ($optionValues as $optionValue) {
                $productVariantOption->optionValues()->create([
                    'product_variant_option_id' => $productVariantOption->id,
                    'attribute' => $validatedData['attribute'], // Use the same attribute set for the option, for the option-value
                    'label' => isset($optionValue['label']) ? $optionValue['label'] : $productVariantOption->label, 
                    'value' => $optionValue['value'],
                ]);
            }
        }

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Product variant option created successfully.',
                'data' => $productVariantOption->load('optionValues'),
            ]);
        }

        return back()->with([
            'status' => 'success',
            'message' => 'Product variant option created successfully.',
            'data' => $productVariantOption->load('optionValues'),
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductVariantOption $productVariantOption)
    {
        $validatedData = $request->validate([
            'attribute' => 'sometimes|required|string|max:255',
            'label' => 'sometimes|required|string|max:255',
        ]);

        $productVariantOption->update($validatedData);

        // If option values are provided, update them for the product variant option
        if ($request->has('option_values')) {
            $optionValues = $request->input('option_values');
            foreach ($optionValues as $optionValue) {
                // Check if the option value already exists
                $existingOptionValue = $productVariantOption->optionValues()
                    ->where('id', $optionValue['id'] ?? null)
                    ->first();  
                if ($existingOptionValue) {
                    // Update existing option value
                    $existingOptionValue->update([
                        'attribute' => $validatedData['attribute'] ?? $existingOptionValue->attribute,
                        'label' => isset($validatedData['label']) ?? $existingOptionValue->label,
                        'value' => $optionValue['value'] ?? $existingOptionValue->value,
                    ]);
                } else {
                    // Create new option value if it doesn't exist
                    $productVariantOption->optionValues()->create([
                        'product_variant_option_id' => $productVariantOption->id,
                        'attribute' => $validatedData['attribute'] ?? $productVariantOption->attribute,
                        'label' => $optionValue['label'] ?? $productVariantOption->label,
                        'value' => $optionValue['value'],
                    ]);
                }
            }
        }   

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Product variant option updated successfully.',
                'data' => $productVariantOption->load('optionValues'),
            ]);
        }

        return back()->with([
            'status' => 'success',
            'message' => 'Product variant option updated successfully.',
            'data' => $productVariantOption->load('optionValues'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductVariantOption $productVariantOptions)
    {
        $productVariantOptions->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Product variant option deleted successfully.',
        ]);
    }

}
