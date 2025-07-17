<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { defineEmits, defineProps, ref, watch } from 'vue';

const props = defineProps<{
    modelValue?: string | null;
}>();

const emit = defineEmits(['update:modelValue', 'uploaded']);

const fileUrl = ref<string | null | undefined>(props.modelValue || undefined);
const fileName = ref<string | null>(null);
const uploading = ref(false);

watch(
    () => props.modelValue,
    (newVal) => {
        fileUrl.value = newVal;
    },
);

const handleFileSelect = async (file: any | null) => {
    if (!file) return;

    const formData = new FormData();
    formData.append('file', file);

    try {
        uploading.value = true;

        const response = await router.post('/api/files', formData, {
            headers: { 'Content-Type': 'multipart/form-data' },
        });

        fileUrl.value = response.data.url;
        fileName.value = response.data.name;
        emit('update:modelValue', response.data.url);
        emit('uploaded', response.data);
    } catch (error) {
        console.error('Upload failed:', error);
        alert('Failed to upload file.');
    } finally {
        uploading.value = false;
    }
};

const clearFile = () => {
    fileUrl.value = undefined;
    fileName.value = null;
    emit('update:modelValue', null);
};
</script>

<template>
    <div class="space-y-2">
        <FormKit
            type="file"
            label="Product Image"
            :value="fileUrl ? [{ name: 'file', value: fileUrl }] : []"
            @input="handleFileSelect"
        />

        <div v-if="uploading" class="text-blue-500">Uploading...</div>

        <div v-if="fileUrl" class="space-y-1">
            <img :src="fileUrl" alt="Uploaded file" class="w-32 rounded" />
            <div class="flex gap-2">
                <a
                    :href="fileUrl"
                    target="_blank"
                    class="text-blue-600 underline"
                    >View</a
                >
                <button @click="clearFile" class="text-red-500 hover:underline">
                    Remove
                </button>
            </div>
        </div>
    </div>
</template>
