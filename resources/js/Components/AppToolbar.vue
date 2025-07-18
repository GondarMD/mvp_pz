<script setup lang="ts">
import { ref, watch, PropType } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { ToolbarItem } from "@/types/app-types.js";

const props = defineProps({
    toolbarItems: {
        type: Array as PropType<ToolbarItem[]>,
        required: true,
    },
    targetObject: Object,
});

function handleToolbarItemClick(item: ToolbarItem) {
    if (typeof item.action === 'function') {
        item.action(props.targetObject);
    }
}

</script>

<template>
    <nav class="app-toolbar">
        <ul class="toolbar-list">
            <li
                v-for="(item, idx) in props.toolbarItems"
                :key="item.id || idx"
                class="toolbar-item"
            >
                <button
                    class="toolbar-btn"
                    :title="item.label"
                    :disabled="item.disabled"
                    @click="handleToolbarItemClick(item)"
                >
                    <span v-if="item.icon" class="toolbar-icon">
                        <i :class="item.icon"></i>
                    </span>
                    <span class="toolbar-label">{{ item.label }}</span>
                </button>
            </li>
        </ul>
    </nav>

    <style scoped>
    .app-toolbar {
        background: #fff;
        border-bottom: 1px solid #e5e7eb;
        padding: 0.5rem 1rem;
        box-shadow: 0 1px 4px rgba(0,0,0,0.03);
        display: flex;
        align-items: center;
    }
    .toolbar-list {
        display: flex;
        gap: 0.5rem;
        list-style: none;
        margin: 0;
        padding: 0;
    }
    .toolbar-item {
        display: flex;
    }
    .toolbar-btn {
        display: flex;
        align-items: center;
        gap: 0.4em;
        background: #f3f4f6;
        border: none;
        border-radius: 6px;
        padding: 0.5em 1em;
        font-size: 1rem;
        color: #374151;
        cursor: pointer;
        transition: background 0.15s, color 0.15s;
    }
    .toolbar-btn:hover:not(:disabled),
    .toolbar-btn:focus-visible:not(:disabled) {
        background: #2563eb;
        color: #fff;
        outline: none;
    }
    .toolbar-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    .toolbar-icon {
        display: flex;
        align-items: center;
        font-size: 1.2em;
    }
    .toolbar-label {
        white-space: nowrap;
    }
    </style>
</template>