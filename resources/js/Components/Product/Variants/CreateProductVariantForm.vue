<script setup lang="ts">
import { ref, reactive, onMounted } from 'vue';
import {router, Link} from '@inertiajs/vue3';

interface VariantOptionValue {
  id: number
  name: string
}

interface VariantOption {
  id: number
  name: string
  type: string
  values: VariantOptionValue[]
}

interface FormState {
  size: string
  design_image: File | null
  design_image_preview: string | null
  option_values: Record<number, number>
}

const props = defineProps<{
  productId: number
}>()

const variantOptions = ref<VariantOption[]>([])
const form = reactive<FormState>({
  size: '',
  design_image: null,
  design_image_preview: null,
  option_values: {}
})

onMounted(async () => {
  const response = await axios.get(`/api/products/${props.productId}/variant-options`)
  variantOptions.value = response.data

  for (const opt of variantOptions.value) {
    form.option_values[opt.id] = 0
  }
})

function handleDesignUpload(file: File[]) {
  if (file && file[0]) {
    form.design_image = file[0]
    form.design_image_preview = URL.createObjectURL(file[0])
  }
}

async function submitForm() {
  const payload = new FormData()
  payload.append('product_id', props.productId.toString())
  payload.append('size', form.size)

  if (form.design_image) {
    payload.append('design_image', form.design_image)
  }

  for (const [optionId, valueId] of Object.entries(form.option_values)) {
    payload.append(`options[${optionId}]`, valueId.toString())
  }

  try {
    await axios.post('/api/product-variants', payload, {
      headers: { 'Content-Type': 'multipart/form-data' }
    })
    alert('Product variant created successfully!')
  } catch (err) {
    console.error(err)
    alert('There was an error saving the product variant.')
  }
}
</script>


<template>
  <FormKit
    type="form"
    :actions="true"
    submit-label="Save Variant"
    @submit="submitForm"
  >
    <FormKit
      type="text"
      name="size"
      label="Size (mm)"
      placeholder="e.g. 300x400"
      validation="required"
      v-model="form.size"
    />

    <FormKit
      type="file"
      name="design_image"
      label="Design Image"
      accept=".jpg,.jpeg,.png"
      @input="handleDesignUpload"
    />

    <div v-if="form.design_image_preview" class="mt-2">
      <img :src="form.design_image_preview" class="h-24 object-contain" alt="Preview" />
    </div>

    <FormKit
      v-for="option in variantOptions"
      :key="option.id"
      type="select"
      :name="'option_' + option.id"
      :label="option.name"
      :options="option.values.map(v => ({ label: v.name, value: v.id }))"
      validation="required"
      v-model="form.option_values[option.id]"
    />
  </FormKit>
</template>
