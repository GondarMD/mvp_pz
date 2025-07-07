<script setup lang="ts">
import { ToolbarType } from '@/types/app-types.js';
import { defineProps } from 'vue';

const props = defineProps<{
    toolbarItems: ToolbarType[];
    targetObject: Object;
    display: boolean;
}>();

function handleClick(item: ToolbarType) {
    if (typeof item.action === 'function') {
        item.action(props.targetObject);
    }
}
</script>

<template>
    <div class="flex w-20 items-center justify-end gap-5">
        <button
            v-for="item in props.toolbarItems"
            :key="item.label"
            @click="handleClick(item)"
            :title="item.label"
            :aria-label="item.label"
            :class="item.class"
        >
            <div
                v-if="props.display"
                class="text-xxs flex flex-col items-center"
            >
                <component
                    :is="item.icon"
                    class="mr-1 h-4 w-4"
                    :color="item.color"
                />
                {{ item.label }}
            </div>
        </button>
    </div>
</template>

<style scoped>
button {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 0.5rem;
    border: none;
    border-radius: 0.375rem;
    cursor: pointer;
    transition: background-color 0.2s ease;
    font-size: 0.75rem;
}
button:disabled {
    cursor: not-allowed;
    opacity: 0.5;
}
button:hover:not(:disabled) {
    background-color: rgba(0, 0, 0, 0.1);
}
</style>
