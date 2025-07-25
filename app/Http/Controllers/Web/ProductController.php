<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Product;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::with('category')->get();
        if ($request->wantsJson()) {
            return [
                'products' => $products,
                'categories' => Category::all(),
                'optionAttributes' => \App\Enums\OptionAttributes::cases()
            ];
        }

        return Inertia::render('Product/ProductListView', [
            'products' => $products,
            'categories' => Category::all(),
            'optionAttributes' => \App\Enums\OptionAttributes::cases()

        ]);
    }

    public function getProductDetails(Request $request, int $productId)
    {
        $product = Product::findOrFail($productId)
            ->load(['category', 'variants.options', 'variants.options.values']);
        if ($request->wantsJson()) {
            return $product;
        }
        return Inertia::render('Products/Details', [
            'product' => $product
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
