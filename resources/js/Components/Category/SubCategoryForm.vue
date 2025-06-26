<!-- 
    This component is used to display a form for creating or editing a subcategory in the admin panel.
//     It uses the useForm hook from Inertia.js to handle form submission and validation.
-->

<script setup
        lang="ts">
            import { ref, watch, PropType } from 'vue';
            import { useForm } from '@inertiajs/vue3';
            import { SubCategory, Category } from '@/types/app-types.js';
            import Modal from '@/Components/Modal.vue';

            const props = withDefaults(
                defineProps<{
                    categories: Array<Category>,
                    subCategory: SubCategory,
                    show: boolean;
                }>(), {
                categories: () => [],
                subCategory: () => ( { id: 0, name: '', slug: '', category_id: 0, description: '' } ),
                show: false,
            } );

            const emit = defineEmits( [ 'close', 'save' ] );

            const form = useForm( {
                name: props.subCategory ? props.subCategory.name : '',
                category_id: props.subCategory ? props.subCategory.category_id : 0,
            } );

            const submit = () => {
                if ( props.subCategory.id != 0 ) {
                    form.post( `/admin/subcategories/${ props.subCategory.id }`, {
                        onSuccess: () => emit( 'save' ),
                    } );
                } else {
                    form.post( '/admin/subcategories', {
                        onSuccess: () => emit( 'save' ),
                    } );
                }
            };

            watch(
                () => props.subCategory,
                ( newSubCategory ) => {
                    if ( newSubCategory ) {
                        form.name = newSubCategory.name;
                        form.category_id = newSubCategory.category_id;
                    } else {
                        form.reset();
                    }
                },
                { immediate: true },
            );

            watch(
                () => props.show,
                ( newShow ) => {
                    if ( !newShow ) {
                        form.reset();
                    }
                },
            );

</script>

<template>
    <Modal :show=" props.show " @close="emit( 'close' )" title="Subcategory Form" >
        <div class="container px-4 py-6">
            <form @submit.prevent=" submit ">
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input v-model=" form.name " type="text" id="name"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        required>
                </div>
                <div class="mb-4">
                    <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                    <select v-model=" form.category_id " id="category_id"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Select a category</option>
                        <option v-for=" category in props.categories " :key=" category.id " :value=" category.id ">
                            {{ category.name }}
                        </option>
                    </select>
                </div>
                <div class="flex justify-end">
                    <button type="button" @click="emit( 'close' )"
                        class="mr-2 px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </Modal>
</template>