<template>
    <div class="space-y-3">
      <h2 class="text-lg font-semibold">Product Variants</h2>
      <div v-for="(variant, i) in modelValue" :key="i" class="border p-2 rounded-xl">
        <FormKit v-model="variant.name" type="text" label="Variant Name (e.g., Size)" />
        <FormKit
          type="textarea"
          label="Options (comma separated)"
          v-model="variant.options"
          help="e.g., Small, Medium, Large"
        />
        <button @click="removeVariant(i)" class="text-red-500 text-sm">Remove</button>
      </div>    
      <button @click="addVariant" class="text-blue-500 text-sm">+ Add Variant</button>
    </div>
  </template>
  
  <script setup lang="ts">
  const props = defineProps<{ modelValue: Array<any> }>()
  const emit = defineEmits(['update:modelValue'])
  
  function addVariant() {
    emit('update:modelValue', [...props.modelValue, { name: '', options: '' }])
  }
  
  function removeVariant(index: number) {
    const updated = [...props.modelValue]
    updated.splice(index, 1)
    emit('update:modelValue', updated)
  }
  </script>