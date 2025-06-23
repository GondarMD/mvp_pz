<!-- 
    This Vue page is used for managing categories in the admin panel.
    It includes functionality to create, update, and delete categories.
    The page is structured to display a list of categories with options to add new ones.
-->

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { router, Link } from '@inertiajs/vue3';
import { Category } from "@/types/app-types.js";
import CategoryForm from '@/Components/Category/CategoryForm.vue';

const props = defineProps<{
    categories: Category[];
}>();

onMounted(() => {
    // This can be used to fetch categories if not passed as props
    // router.get('/admin/categories');
});

const showForm = ref(false);
const newCategory = ref<Category>({ id: 0, name: '', slug: '' });

function handleCategoryEdit(category: Category) {
    newCategory.value = { ...category };
    showForm.value = true;
}           

</script>

<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Category Management</h1>
        
        <button @click="showForm=true" class="bg-blue-500 text-white px-4 py-2 rounded mb-4">
        Add New Category
        </button>

        <CategoryForm :category="newCategory" :show="showForm" @close="router.visit('/admin/categories')" />
    
        <table class="min-w-full bg-white border border-gray-200">
        <thead>
            <tr>
            <th class="px-6 py-3 border-b border-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">ID</th>
            <th class="px-6 py-3 border-b border-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Name</th>
            <th class="px-6 py-3 border-b border-gray-200"></th>
            </tr>
        </thead>
        <tbody>
            <!-- Loop through categories -->
            <tr v-for="category in props.categories" :key="category.id">
            <td class="px-6 py-4 border-b border-gray-200">{{ category.id }}</td>
            <td class="px-6 py-4 border-b border-gray-200">{{ category.name }}</td>
            <td class="px-6 py-4 border-b border-gray-200">
                <button @click="handleCategoryEdit(category)" class="text-blue-600 hover:text-blue-900">Edit</button>
                <button @click="router.delete(`/admin/categories/${category.id}`)" class="text-red-600 hover:text-red-900 ml-2">Delete</button>
            </td>
            </tr>
        </tbody>
        </table>
    </div>

</template>