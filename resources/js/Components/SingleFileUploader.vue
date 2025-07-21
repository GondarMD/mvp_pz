<script setup lang="ts">
import { ref, watch, defineProps, defineEmits } from 'vue'
import { useForm } from '@inertiajs/vue3'

const props = defineProps<{
  modelValue?: string | null
}>()

const emit = defineEmits(['update:modelValue', 'uploaded'])

const fileUrl = ref<string | null | undefined>(props.modelValue || null)
const fileName = ref<string | null>(null)
const uploading = ref(false)

watch(() => props.modelValue, (newVal) => {
  fileUrl.value = newVal
})

const handleFileSelect = async (value: unknown, node: any) => {
  // value; {name: '', file: File}
  let files: FileList | File[] | null = null;

  if (value instanceof FileList) {
    files = value;
  } else if (Array.isArray(value) && value.length && value[0].file instanceof File) {
    files = value.map((item: any) => item.file);
  }

  if (!files || files.length === 0) return;
  const file = files[0];  

  const form = useForm({
    file,
  });

  uploading.value = true;

  form.post('/files', {
    preserveScroll: true,
    onSuccess: (data) => {

      const uploadedUrl = `/storage/app/public/uploads/${file.name}`; // Adjust if your Laravel controller returns something different

      fileUrl.value = uploadedUrl;
      fileName.value = file.name;
      emit('update:modelValue', uploadedUrl);
      emit('uploaded', { name: file.name, url: uploadedUrl });
    },
    onError: () => {
      console.log('Upload failed.');
    },
    onFinish: () => {
      uploading.value = false;
    },
  });
}

const clearFile = () => {
  fileUrl.value = null
  fileName.value = null
  emit('update:modelValue', null)
}
</script>

<template>
  <div class="space-y-2">
    <FormKit
      type="file"
      label="Product Image"
      :value="undefined"
      @input="handleFileSelect"
    />

    <div v-if="uploading" class="text-blue-500">Uploading...</div>

    <div v-if="fileUrl" class="space-y-1">
      <img :src="fileUrl" alt="Uploaded file" class="w-32 rounded border" />
      <div class="flex gap-2">
        <a :href="fileUrl" target="_blank" class="text-blue-600 underline">View</a>
        <button @click="clearFile" class="text-red-500 hover:underline">Remove</button>
      </div>
    </div>
  </div>
</template>

