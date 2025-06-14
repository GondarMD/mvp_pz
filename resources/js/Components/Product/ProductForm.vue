
<script setup lang="ts">
import { ref } from 'vue'
import ProductVariants from './Variants/ProductVariantsForm.vue'
import ProductCustomizations from './Customizations/ProductCustomizationsForm.vue'

const form = ref({ variants: [], customizations: [] })
const categories = ref([]) // Populate from API or props

function saveProduct(data: any) {
  console.log('Save product', data)
  // Submit logic here
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
      <FormKit name="name" label="Product Name" type="text" validation="required" />
      <FormKit name="description" label="Description" type="textarea" />
      <FormKit name="price" label="Base Price ($)" type="number" step="0.01" validation="required" />
      <FormKit name="category_id" label="Category" type="select" :options="categories" />

      <ProductVariants v-model="form.variants" />
      <ProductCustomizations v-model="form.customizations" />
    </FormKit>
  </div>
</template>

