<!-- 
    This component is used to display a form for creating or editing a category in the admin panel.
-->

<script setup
        lang="ts">
            import { ref, watch, PropType } from 'vue';
            import { useForm } from '@inertiajs/vue3';
            import { Category } from '@/types/app-types.js';
            import Modal from '@/Components/Modal.vue';

            const props = withDefaults(
                defineProps<{
                    category: Category,
                    show: boolean
                }>(), {
                    category: () => ({ id: 0, name: '', slug: '' }),
                    show: false,
                });

            const emit = defineEmits( [ 'close', 'save' ] );

            const form = useForm( {
                name: props.category ? props.category.name : '',
            } );

            const submit = () => {
                if ( props.category.id != 0 ) {
                    form.post( `/admin/categories/${ props.category.id }`, {
                        onSuccess: () => emit( 'save' ),
                    } );
                } else {
                    form.post( '/admin/categories', {
                        onSuccess: () => emit( 'save' ),
                    } );
                }   
            };

            watch(
                () => props.category,
                ( newCategory ) => {
                    if ( newCategory ) {
                        form.name = newCategory.name;
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

    <Modal :show="props.show" @close="emit( 'close' )" maxWidth="lg">
        <form @submit.prevent=" submit ">
            <div class="p-6">
                <h2 class="text-lg font-semibold mb-4">
                    {{ props.category ? 'Edit Category' : 'Create Category' }}
                </h2>
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Category Name</label>
                    <input v-model=" form.name " type="text" id="name"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required />
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-50 text-right">
                <button type="button" @click="emit( 'close' )"
                    class="inline-flex justify-center px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 mr-2">
                    Cancel
                </button>
                <button type="submit"
                    class="inline-flex justify-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Save
                </button>
            </div>
        </form>
    </Modal>
</template>