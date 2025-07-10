<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()?->can('create', \App\Models\Product::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
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
        ];
    }

    public function wantsJson() {
        return request()->wantsJson();
    }
}
