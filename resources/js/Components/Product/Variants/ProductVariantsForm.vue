<script setup lang="ts">
import { ref } from 'vue';
import { LabelValue, ProductVariant, ProductVariantOption } from '@/types/app-types';
import { useForm, usePage } from '@inertiajs/vue3';

const props = defineProps<{
    modelValue: Array<ProductVariant>,
    optionAttributes: Array<LabelValue>,
}>();

const emit = defineEmits(['update:modelValue']);

const page = usePage();
const form = useForm({
    _variant: {} as ProductVariantOption,
});
const selectedSizeOption = ref('');

function addVariant() {
    emit('update:modelValue', [...props.modelValue, { name: '', options: '' }]);
}

function removeVariant(index: number) {
    const updated = [...props.modelValue];
    updated.splice(index, 1);
    emit('update:modelValue', updated);
}

function addVariantAttribute(value: string) {
    const match = props.optionAttributes.find(
        (option) => option.value === value
    );

    if (!match) return;


}
</script>
<template>
    <div class="space-y-3">
        <div
            v-for="(variant, i) in modelValue"
            :key="i"
            class="rounded-xl border p-2"
        >
            <FormKit
                v-model="variant.name"
                type="text"
                label="Variant Name (e.g., Size)"
            />
            <div class="flex w-full gap-4">
                <FormKit
                    input-class="w-96"
                    type="select"
                    label="Size"
                    v-model="selectedSizeOption"
                    help="e.g., Small, Medium, Large"
                    :options="props.optionAttributes"
                />
                <button
                    @click="addVariantAttribute(selectedSizeOption)"
                    class="text-sm text-blue-500"
                >
                    + Add Variant Option
                </button>
            </div>
            <button @click="removeVariant(i)" class="text-sm text-red-500">
                Remove
            </button>
        </div>
        <button @click="addVariant" class="text-sm text-blue-500">
            + Add Variant
        </button>
    </div>
</template>
