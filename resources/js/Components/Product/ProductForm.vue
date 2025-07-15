
<script setup lang="ts">
import { ref, computed } from 'vue';
import {useForm, usePage} from '@inertiajs/vue3';
import {Category, Product, ProductVariant, ProductCustomization, LabelValue} from '@/types/app-types';

import ProductVariantsForm from './Variants/ProductVariantsForm.vue';
import ProductCustomizationsForm from './Customizations/ProductCustomizationsForm.vue';

const page = usePage();
const form = useForm({
    _product: {} as Product,
    variants: [] as ProductVariant[],
    customizations: [] as ProductCustomization[]
});
const categories = ref([]) // Populate from API or props
const attributeOptions = page.props.option_attributes as LabelValue[];

function saveProduct(data: any) {
  console.log('Save product', data)
  // Submit logic here
}

const base_price = computed(() => (form._product.price as Number || 0).toFixed(2));

const form_category_objects = computed(() => {
    const options = [] as { value: number, label: string }[];
    (page.props.categories as Category[]).map(category => {
        options.push( {
            value: category.id,
            label: category.name
        });
    })

    return options;
});

const form_subcategory_objects = computed(() => {
    if (!form._product.category_id) {
        return [];
    }

    const options = [] as { value: number, label: string }[];
    const selectedCategory = (page.props.categories as Category[]).find(category => category.id == form._product.category_id);
    if (selectedCategory) {
        selectedCategory.subcategories.map(subcategory => {
            options.push( {
                value: subcategory.id,
                label: subcategory.name
            });
        })
    }

    return options;
})

function handleAddVariant (variant: ProductVariant) {
    form.variants.push(variant);
}
</script>

<template>
  <div class="p-4 max-w-5xl mx-auto space-y-6">
    <FormKit
      type="form"
      submit-label="Save Product"
      :actions="true"
      @submit="saveProduct"
    >
      <FormKit v-model="form._product.name" name="name" label="Product Name" type="text" validation="required" />
      <FormKit v-model="form._product.description" name="description" label="Description" type="textarea" />
      <div class="flex gap-4">
      <FormKit input-class="w-20" v-model="base_price" name="p=rice" label="Base Price ($)" type="number" step="0.01" validation="required" />
      <FormKit  input-class="w-96" v-model="form._product.category_id" name="category_id" label="Category" type="select" :options="form_category_objects"  />
      <FormKit input-class="w-80" v-model="form._product.sub_category_id" name="sub_category_id" label="Sub Category" type="select" :options="form_subcategory_objects" :enabled="form._product.category_id"/>
      </div>

      <ProductVariantsForm v-model="form.variants" :option-attributes="attributeOptions" @update:model-value="handleAddVariant"/>
      <ProductCustomizationsForm v-model="form.customizations" />
      </FormKit>
  </div>
</template>

