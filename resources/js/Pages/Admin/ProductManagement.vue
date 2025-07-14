<script setup lang="ts">
import {ref, computed} from 'vue';
import { Link, router } from '@inertiajs/vue3';
import {Category, Product, PaginatedProductPage} from "@/types/app-types";
import ProductForm from "@/Components/Product/ProductForm.vue";

const props = defineProps<{
    products: Product[];
    categories: Category[]
}>();

const showCreateProductForm = ref(false);
</script>

<template>

<ProductList :products="props.products" :categories="props.categories"/>

<Link :href="route('admin.product.create')" class="bg-[#FF2D20] text-white px-3 py-2 rounded-md">Create Product</Link>
<ProductForm v-if="showCreateProductForm" :categories="props.categories" />

</template>
