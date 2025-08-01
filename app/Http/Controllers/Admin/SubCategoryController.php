<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SubCategory;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, int $categoryId)
    {
        if ($categoryId) {
            $subCategories = SubCategory::where('category_id', $categoryId)->get();
        } else {
            // If no category ID is provided, fetch all subcategories
            $subCategories = SubCategory::all();
        }


        if (request()->wantsJson()) {
            return $subCategories;
        }

        return back()->with([
            'subCategories' => $subCategories,
            'categoryId' => $categoryId
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id'
        ]);

        $subCategory = SubCategory::create($request->only('name', 'category_id'));

        return $request->wantsJson()
            ? $subCategory
            : redirect()->back()->with('success', 'Sub-category created');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $subCategoryId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id'
        ]);

        try {

            $subCategory = SubCategory::findOrFail($subCategoryId);
            $subCategory->update($request->only('name', 'category_id'));
        }

        catch (\Exception $ex) {
            return back()->with('error', $ex->getMessage());
        }

        return $request->wantsJson()
            ? $subCategory
            : redirect()->back()->with('success', 'Sub-category updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $subCategoryId)
    {
        $subCategory = SubCategory::findOrFail($subCategoryId);

        $subCategory->delete();

        return request()->wantsJson()
            ? response()->noContent()
            : redirect()->back()->with('success', 'Sub-category deleted');
    }
}
