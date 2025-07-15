<script setup lang="ts">
import { LabelValue, ProductVariant } from '@/types/app-types';
import { useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import ProductVariantOptionForm from "./ProductVariantOptionForm.vue";

const props = defineProps<{
    modelValue: Array<ProductVariant>;
    optionAttributes: Array<LabelValue>;
}>();

const emit = defineEmits(['update:modelValue', 'addAttribute']);

const page = usePage();
const form = useForm({
    _variant: {} as ProductVariant,
});
const selectedSizeOption = ref('');
const definedAttributes = [] as string[];
const definedValues = [] as string[];

let attribute_key = ref('');
let attribute_value = ref('');
const attributeCount = ref(0);

// attribute options
const sizeOptions = [
    {label: 'Small', value: 'small'},
    {label: 'Medium', value: 'medium'},
    {label: 'Large', value: 'large'},
];

const colorOptions = [
    {label: 'Red', value: 'red'},
    {label: 'Blue', value: 'blue'},
    {label: 'Green', value: 'green'},
];

const designOptions = [
    {label: 'Pattern 1', value: 'pattern-1'},
    {label: 'Pattern 2', value: 'pattern-2'},
    {label: 'Rectangular Portrait', value: 'rect-portrait'},
    {label: 'Rectangular Landscape', value: 'rect-landscape'},
];

function handleAddVariant(variant: ProductVariant) {
    emit('update:modelValue', [...props.modelValue, variant]);
}

function addVariant() {
    emit('update:modelValue', [...props.modelValue, form._variant]);
}

function removeVariant(index: number) {
    const updated = [...props.modelValue];
    updated.splice(index, 1);
    emit('update:modelValue', updated);
}

function addVariantAttribute(key: string, value: string) {
    form._variant.variant_attributes.push({
        id: 0,
        product_variant_id: form._variant.id,
        attribute_key: key,
        attribute_value: value,
    });

    attributeCount.value++;
    emit('update:modelValue', form._variant);
}

function handleAttributeValueCaptured(value: string) {
    console.log('Captured value = ', value);
}

function handleAttributeSelection(event: any) {
    attribute_key.value = event.target.value;
    console.log(attribute_key.value);
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
                label="Variant Name"
                help="Use a name that will describe the variant, and differentiate it from other variants. For instance, ''Small-White-Cotton' to indicate a variant made from white cotton and of small size. "
            />
            <div class="flex w-full gap-4">
                <FormKit
                    input-class="w-96"
                    type="select"
                    label="Attribute"
                    v-model="attribute_key"
                    help="Select the variant attribute, e.g. 'Size', 'Color', etc."
                    :options="props.optionAttributes"
                    @change="handleAttributeSelection($event)"
                />

                <!-- Enable the relevant AttributeOptionForm based on the selected attribute -->
                <ProductVariantOptionForm v-show="attribute_key == 'size'" :selected-attribute="attribute_key" :attribute-option-values="sizeOptions" :customValue="attribute_value" @valueEntered="handleAttributeValueCaptured" />
                <ProductVariantOptionForm v-show="attribute_key == 'color'" :selected-attribute="attribute_key" :attribute-option-values="colorOptions" :customValue="attribute_value" @valueEntered="handleAttributeValueCaptured" />
                <ProductVariantOptionForm v-show="attribute_key == 'material'" :selected-attribute="attribute_key" :attribute-option-values=null :customValue="attribute_value" @valueEntered="handleAttributeValueCaptured" />
                <ProductVariantOptionForm v-show="attribute_key == 'style'" :selected-attribute="attribute_key" :attribute-option-values="designOptions" :customValue="attribute_value" @valueEntered="handleAttributeValueCaptured" />
                <!-- <button
                    @click="addVariantAttribute(attribute_key, attribute_value)"
                    class="text-sm text-blue-500"
                >
                    + Add Variant Attribute
                </button> -->
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
