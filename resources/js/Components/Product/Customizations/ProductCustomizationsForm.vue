<template>
  <div class="space-y-3">
    <h2 class="text-lg font-semibold">Product Customizations</h2>
    <div v-for="(field, i) in modelValue" :key="i" class="border p-2 rounded-xl">
      <FormKit type="text" label="Label" v-model="field.label" />
      <FormKit
        type="select"
        label="Input Type"
        v-model="field.type"
        :options="['text', 'textarea', 'file']"
      />
      <FormKit type="checkbox" label="Required?" v-model="field.required" />
      <button @click="removeField(i)" class="text-red-500 text-sm">Remove</button>
    </div>
    <button @click="addField" class="text-blue-500 text-sm">+ Add Customization</button>
  </div>
</template>

<script setup lang="ts">
const props = defineProps<{ modelValue: Array<any> }>()
const emit = defineEmits(['update:modelValue'])

function addField() {
  emit('update:modelValue', [...props.modelValue, { label: '', type: 'text', required: false }])
}

function removeField(index: number) {
  const updated = [...props.modelValue]
  updated.splice(index, 1)
  emit('update:modelValue', updated)
}
</script>
