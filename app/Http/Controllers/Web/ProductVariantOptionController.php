<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

use App\Models\ProductVariantOption;

class ProductVariantOptionController extends Controller
{
    /**
     * Display a listing of the product variant options, given the product.
     */
    public function index(Request $request, int $productId)
    {
        $productVariantOptions = ProductVariantOption::where('product_id', $productId)->get();

        $productVariantOptions->load('optionValues');

        if ($request->wantsJson()) {
            return response()->json($productVariantOptions);
        }

        // If the request is not JSON, return an Inertia view
        return back()->with([
            'status' => 'success',
            'message' => 'Product variant options retrieved successfully.',
            'data' => $productVariantOptions,
        ]);
    }
}
