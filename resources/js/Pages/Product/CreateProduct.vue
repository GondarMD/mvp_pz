<script setup
        type="ts">
            import { reactive, onMounted } from 'vue';
            import { usePage, useForm } from '@inertiajs/vue3';
            import { FormKit } from "@formkit/vue";

            const product = reactive( {
                name: '',
                description: '',
                price: null,
                category: '',
                images: [],
                variants: [],
                customizations: [],
            } );

            const page = usePage();
            const form = useForm( {
                _product: product,
                quantity: 1,
            } );


            onMounted( () => {
                // Initialize product data if available
                if ( page.props.product )
                {
                    Object.assign( product, page.props.product );
                }
            } );

            const categories = reactive( page.props.categories || [] );

            function addVariant () {
                product.variants.push( { name: '', price: null } );
            }

            function removeVariant ( index ) {
                product.variants.splice( index, 1 );
            }

            function addCustomization () {
                product.customizations.push( { name: '', options: '' } );
            }

            function removeCustomization ( index ) {
                product.customizations.splice( index, 1 );
            }

            function handleImageUpload ( event ) {
                const files = event.target.files;
                for ( let i = 0; i < files.length; i++ )
                {
                    const reader = new FileReader();
                    reader.onload = ( e ) => {
                        this.product.images.push( e.target.result );
                    };
                    reader.readAsDataURL( files[ i ] );
                }
            }

            function submitForm () {
                console.log( 'Product Data:', product );
                // Add your form submission logic here
            }

</script>

<template>
    <div class="create-product-page container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">Create Product</h1>
        <form @submit.prevent=" submitForm " class="space-y-6">
            <!-- Product Name -->
            <FormKit type="text" name="name" label="Product Name" v-model=" product.name " validation="required"
                placeholder="Enter product name" />

            <!-- Product Description -->
            <FormKit type="textarea" name="description" label="Description" v-model=" product.description "
                placeholder="Enter product description" validation="required" rows="4" />

            <!-- Product Price -->
            <FormKit type="number" name="price" label="Price" v-model=" product.price " validation="required|number"
                placeholder="Enter product price" />

            <!-- Product Category -->
            <FormKit type="select" name="category" label="Category" v-model=" product.category " validation="required"
                :options=" categories.map( category => ( { value: category.id, label: category.name } ) ) "
                placeholder="Select a category" />

            <!-- Product Images -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Product Images</label>
                <FormKit type="file" multiple @change=" handleImageUpload "
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                <div class="mt-2 flex space-x-4">
                    <img v-for=" ( image, index ) in product.images " :key=" index " :src=" image " alt="Product Image"
                        class="w-20 h-20 object-cover rounded-md" />
                </div>
            </div>

            <!-- Product Variants -->
            <div>
                <h2 class="text-lg font-semibold mb-2">Product Variants</h2>
                <div v-for=" ( variant, index ) in product.variants " :key=" index " class="space-y-2">
                    <FormKit type="group" :default-value=" { name: '', price: null } ">
                        <FormKit type="text" name="name" label="Variant Name" v-model=" variant.name "
                            validation="required" placeholder="Variant Name" />
                        <FormKit type="number" name="price" label="Variant Price" v-model=" variant.price "
                            validation="required|number" placeholder="Variant Price" />
                    </FormKit>
                    <button type="button" @click="removeVariant( index )" class="text-red-500 hover:text-red-700">
                        Remove
                    </button>
                </div>
                <button type="button" @click=" addVariant " class="mt-2 text-indigo-600 hover:text-indigo-800">
                    + Add Variant
                </button>
            </div>

            <!-- Product Customizations -->
            <div>
                <h2 class="text-lg font-semibold mb-2">Product Customizations</h2>
                <div v-for=" ( customization, index ) in product.customizations " :key=" index " class="space-y-2">
                    <div class="flex space-x-4">
                        <FormKit type="text" v-model=" customization.name "
                            class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Customization Name" required />
                        <FormKit type="text" v-model=" customization.options "
                            class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Options (comma-separated)" required />
                        <button type="button" @click="removeCustomization( index )"
                            class="text-red-500 hover:text-red-700">
                            Remove
                        </button>
                    </div>
                </div>
                <div v-if=" product.customizations.length === 0 " class="text-gray-500">
                    No customizations added yet.
                </div>
                <button v-else type="button" @click="removeCustomization( index )"
                    class="text-red-500 hover:text-red-700">
                    Remove
                </button>
            </div>


            <button type="button" @click=" removeCustomization( index )" class="text-red-500 hover:text-red-700">
                Remove
            </button>

            <button type="button" @click=" addCustomization " class="mt-2 text-indigo-600 hover:text-indigo-800">
                + Add Customization
            </button>

            <!-- Submit Button -->
            <div>
                <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700">
                    Create Product
                </button>
            </div>
        </form>
    </div>


</template>



<style scoped>
    .container {
        max-width: 800px;
    }
</style>