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

<slot name="main">
<ProductList v-if="props.products" :products="props.products" :categories="props.categories"/>

<div class="text-center" >
<h2 class="text-xl m-20 ">No Products defined...</h2>
</div>
</slot>

<div class="flex justify-center bg-slate-300">
<button @click="showCreateProductForm = true" class="mx-auto my-5 bg-[#FF2D20] text-white px-3 py-2 rounded-md" :class="{'hidden': showCreateProductForm}">Create Product</button>
<ProductForm v-if="showCreateProductForm" :categories="props.categories" />

</div>

</template>
