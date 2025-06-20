<script setup
        lang="ts">
            import { ref, onMounted } from 'vue';
            import { Product, ProductVariant } from '@/types/app-types';
            import { usePage } from '@inertiajs/vue3';

            const page = usePage();
            const product = ref( page.props.product );
            const productVariants = ref( page.props.productVariants as ProductVariant[] );
            const productOptions = ref( page.props.productOptions );
            const productOptionsValues = ref( page.props.productOptionsValues );

            import { useForm } from '@inertiajs/vue3';
            import { TypeFlags } from "typescript";

            const form = useForm<{ _product: Product; quantity: number; }>( {
                _product: {} as Product,
                quantity: 1,
            } );

</script>

<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">{{ form._product.name }}</h1>
        <p class="mb-4">{{ form._product.description }}</p>
        <p class="text-lg font-semibold mb-4">Base Price: ${{ form._product.price.toFixed( 2 ) }}</p>

        <form @submit.prevent="form.post( '/cart/add' )" class="mb-4">
            <div class="flex items-center mb-4">
                <label for="quantity" class="mr-2">Quantity:</label>
                <input type="number" id="quantity" v-model.number=" form.quantity " min="1"
                    class="border rounded p-2 w-20" />
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Add to Cart
            </button>
        </form>

        <!-- Show product variants -->
        <div v-if=" form._product.base_image_url " class="mb-4">
            <div class="flex">
                <div class="flex-1">
                    <h2 class="text-xl font-semibold mb-2">Available Variants</h2>
                    <ul>
                        <li v-for=" ( variant, index ) in productVariants " :key=" index " class="mb-2">
                            <p class="text-sm">{{ variant.sku }}<span>: {{ variant.name }}</span></p>
                            <img :src=" variant.image_url " alt="Variant Image" class="w-[80%] h-auto" />
                            <div class="ml-4 flex-1">
                                <img v-for=" ( image, index ) in variant.variant_image_urls " :key=" index " :src="image "
                                    alt="Additional Variant Images" class="w-20 h-20 object-cover mb-2 mr-2" />

                            </div>
                        </li>
                    </ul>F
                </div>
            </div>
        </div>

</template>