<script setup lang="ts">
import { LabelValue } from '@/types/app-types';
const props = defineProps<{
    selectedAttribute: string;
    attributeOptionValues: Array<LabelValue> | null;
    customValue: string;
}>();

const emit = defineEmits(['valueEntered']);

function valueEntered() {
    emit('valueEntered', props.customValue);
}

function handleOptionSelected(item: string) {
    emit('valueEntered', { label: props.selectedAttribute, value: item });
}
</script>

<template>
    <div
        v-if="props.attributeOptionValues"
        class="flex flex-col gap-4 border-2 border-sky-100 p-4"
    >
        <span class="text-sm/6 font-bold"> Attribute Options</span>

        <ul>
            <li
                v-for="option in props.attributeOptionValues"
                :key="option.value"
            >
                <p
                    class="cursor-pointer text-gray-500 hover:bg-black hover:text-white"
                    @click="handleOptionSelected(option.value)"
                    :value="option.value"
                >
                    {{ option.label }}
                </p>
            </li>
        </ul>
    </div>
    <div class="flex flex-col gap-4 border-2 border-sky-100 p-4" v-else>
        <span class="text-sm/6 font-bold">Attribute Value</span>
        <FormKit
            type="text"
            v-model="props.customValue"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        />
    </div>
</template>
