export type Product = {
    id: number,
    name: string,
    description: string,
    price: number,
    is_digital: boolean,
    is_active: boolean,
    category_id: number,
    sub_category_id: number,
    base_image_url: string,
    thumbnail_image_url: string,
    product_video_url: string,
    product_pdf_url: string,
    product_3d_model_url: string,
    product_3d_model_thumbnail_url: string,
    created_at: string,
    updated_at: string,
}

export type  PaginatedProductPage = {
    data: Array<Product>,
    links: {
        first: string,
        last: string,
        prev: string,
        next: string,
    },
    meta: {
        current_page: number,
        from: number,
        last_page: number,
        per_page: number,
        to: number,
        total: number,
    }
}

export type Category = {
    id: number,
    name: string,
    slug: string,
    subcategories: Array<SubCategory>,
    description: string,
}

export type SubCategory = {
    id: number,
    name: string,
    description: string,
    category_id: number,
    is_selected: boolean,
}

export type ProductVariant = {
    id: number,
    product_id: number,
    name: string,
    variant_price: number,
    sku: string,
    barcode: string,
    stock_quantity: number,
    image_url: string,
    thumbnail_image_url: string,
    variant_image_urls: Array<string>,
    video_url: string,
    pdf_url: string,
    model_3d_url: string,
    model_3d_thumbnail_url: string,
    is_active: boolean,
    is_digital: boolean,
    is_default: boolean,
    variant_attributes: Array<ProductVariantOption>,
    created_at: string,
    updated_at: string,
}

export type ProductVariantOption = {
    id: number,
    product_variant_id: number,
    attribute_key: string,
    attribute_value: string,
}

export type LabelValue = {
    label: string,
    value: string
}

export type ProductCustomization = {
    id: number,
    product_id: number,
    label: string,
    type: string,
    required: boolean,
    placeholder: string,
    default_value: string,
    file_type: string,
    max_file_size: number,
    is_active: boolean,
    options: Array<string>,
    validation_rules: string,
}

// UI types
export type ToolbarType = {
    action: (parameter: any) => void,
    label: string,
    enabled: boolean,
    icon?: Object,
    class: string,
    displayOnMultipleSelect?: boolean,
    color: string,
}
