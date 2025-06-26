<!-- 
    This Vue page is used for managing categories in the admin panel.
    It includes functionality to create, update, and delete categories.
    The page is structured to display a list of categories with options to add new ones.
-->

<script setup
        lang="ts">
            import { ref, onMounted } from 'vue';
            import { usePage } from '@inertiajs/vue3';
            import { router, Link } from '@inertiajs/vue3';
            import { Category, SubCategory } from "@/types/app-types.js";
            import CategoryForm from '@/Components/Category/CategoryForm.vue';
            import SubCategoryForm from "@/Components/Category/SubCategoryForm.vue";

            import { PencilLine, Plus, Trash, Trash2 } from 'lucide-vue-next';

            const props = defineProps<{
                categories: Category[];
            }>();

            onMounted( () => {
                // This can be used to fetch categories if not passed as props
                // router.get('/admin/categories');
            } );

            const showForm = ref( false );
            const showSubcatForm = ref( false );
            const newCategory = ref<Category>( { id: 0, name: '', slug: '', subcategories: Array<SubCategory>(), description: '' } );
            const newSubCategory = ref<SubCategory>( { id: 0, name: '', category_id: 0, description: '' } );

            function handleCategoryEdit( category: Category ) {
                newCategory.value = { ...category };
                showForm.value = true;
            }

            function triggerSubcategoryManagement( category: Category ) {
                newSubCategory.value = { id: 0, name: '', category_id: category.id, description: '' };
                showSubcatForm.value = true;
            }

</script>

<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Category Management</h1>

        <button @click="showForm = true" class="bg-blue-500 text-white px-4 py-2 rounded mb-4">
            Add New Category
        </button>

        <CategoryForm :category=" newCategory " :show=" showForm " @close="router.visit( '/admin/categories' )" />

        <SubCategoryForm :categories=" props.categories " :subCategory=" newSubCategory " :show=" showSubcatForm "
            @close="showSubcatForm = false" @save="showSubcatForm = false" />

        <table class="min-w-full bg-white border border-black divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="w-1/2 text-left">
                        Name</th>
                    <th class="w-1/2 text-right">
                        Subcategories</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop through categories -->
                <tr v-for=" category in props.categories " :key=" category.id ">
                    <td>
                        <div class="flex text-left items-center">
                            <span class="flex-1 p-6">{{ category.name }}</span>
                            <button @click="handleCategoryEdit( category )"
                                class="text-blue-600 hover:text-blue-900 text-xs w-4">
                                <PencilLine class="h-4" />Edit
                            </button>
                            <button @click="router.delete( `/admin/categories/${ category.id }` )"
                                class="px-6 text-red-600 hover:text-red-900 ml-4 text-xs w-4">
                                <Trash2 class="h-4" />Delete
                            </button>
                        </div>
                    </td>
                    <td>
                        <div >
                            <ul v-if=" category.subcategories && category.subcategories.length > 0 ">
                                <li v-for=" subcategory in category.subcategories " :key=" subcategory.id ">
                                    <div class="flex items-center justify-between">
                                        <span class="flex-1">{{ subcategory.name }}</span>
                                        <div class="flex items-center justify-end">
                                            <button class="text-blue-500 text-xxs cursor-pointer    "
                                                @click="triggerSubcategoryManagement( category )">
                                                <Plus class="h-4" />Add  
                                            </button>
                                            <button class="text-blue-500 text-xs ml-2">
                                                <PencilLine class="h-4" />Edit
                                            </button>
                                            <button class="text-red-500 text-xs ml-2 cursor-pointer"
                                                @click="router.delete( `/admin/subcategories/${ subcategory.id }` )">
                                                <Trash2 class="h-4" />Delete
                                            </button>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <span v-else class="flex justify-between ">
                                <span class="italic font-semibold">No subcategories defined</span>
                                <button class="text-blue-500 text-xs ml-2"
                                    @click="triggerSubcategoryManagement( category )">
                                    <Plus class="h-4" />Add
                                </button>
                            </span>
                        </div>
                    </td>

                </tr>
            </tbody>
        </table>
    </div>

</template>

<style scoped>
.text-xxs {
    font-size: 0.75rem;
    line-height: 0.75rem    ;
}
</style>