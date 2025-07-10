<script setup lang="ts">
import {ref, computed} from 'vue';
import { Link, router } from '@inertiajs/vue3';
import {Category, Product} from "@/types/app-types";
import ProductForm from "@/Components/Product/ProductForm.vue";

const props = defineProps<{
    products: Product[];
    categories: Category[]
}>();

</script>

<template>

<ProductForm :products="props.products" :categories="props.categories" />

</template>
