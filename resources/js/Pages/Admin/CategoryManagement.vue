<!--
    This Vue page is used for managing categories in the admin panel.
    It includes functionality to create, update, and delete categories.
    The page is structured to display a list of categories with options to add new ones.
-->

<script setup lang="ts">
import CategoryForm from '@/Components/Category/CategoryForm.vue';
import SubCategoryForm from '@/Components/Category/SubCategoryForm.vue';
import { Category, SubCategory } from '@/types/app-types.js';
import { router } from '@inertiajs/vue3';
import { computed, onMounted, ref } from 'vue';

import FormToolbar from '@/Components/FormToolbar.vue';
import { PencilLine, Plus, Trash2 } from 'lucide-vue-next';

const props = defineProps<{
    categories: Category[];
}>();

onMounted(() => {
    // This can be used to fetch categories if not passed as props
    // router.get('/admin/categories');
    props.categories.forEach((category) => {
        category.subcategories.forEach((subcategory) => {
            subcategory.is_selected = false; // Initialize is_selected for each subcategory
        });
    });
});

const showForm = ref(false);
const showSubcatForm = ref(false);
const newCategory = ref<Category>({
    id: 0,
    name: '',
    slug: '',
    subcategories: Array<SubCategory>(),
    description: '',
});
const newSubCategory = ref<SubCategory>({
    id: 0,
    name: '',
    category_id: 0,
    description: '',
    is_selected: false, // Ensure is_selected is initialized
});
const selectedCategory = ref<Category | null>(null);
const selectedSubCategory = ref<SubCategory | null>(null);
const toggleAllSelection = ref(false);

const multipleSubcategoriesSelected = computed(() => {
    var hasSelected = false;
    hasSelected = selectedCategory.value
        ? selectedCategory.value.subcategories.some(
              (subcat) => subcat.is_selected,
          )
        : false;
    return hasSelected;
});

// Toolbar definitions
const SubcategoryEditToolbarItems = ref([
    {
        label: 'Edit',
        icon: PencilLine,
        enabled: false, // Initially disabled, can be enabled based on selection
        action: (category: SubCategory) => {
            handleEditSubcategory(category);
        },
        class: 'mr-2 btn-secondary',
        color: 'blue',
        displayOnMultipleSelect: false, // Do not display if multiple subcategories are selected
    },
    {
        label: 'Delete',
        icon: Trash2,
        enabled: false, // Initially disabled, can be enabled based on selection
        action: (subcategory: SubCategory) => {
            router.delete(`/admin/subcategories/${subcategory.id}`);
        },
        class: 'btn-danger',
        displayOnMultipleSelect: true, // Display if multiple subcategories are selected
        color: 'red',
    },
]);

const SubcategoryAddToolbarItems = ref([
    {
        label: 'Add',
        icon: Plus,
        enabled: true,
        action: (category: Category) => {
            triggerSubcategoryManagement(category);
        },
        class: 'btn-primary',
        displayOnMultipleSelect: true, // Always display add option
        color: 'blue',
    },
]);

const CategoryToolbarItems = ref([
    {
        label: 'Edit',
        icon: PencilLine,
        enabled: true,
        action: (category: Category) => {
            handleCategoryEdit(category);
        },
        class: 'btn-secondary',
        displayOnMultipleSelect: true, // Always display edit option for Categories (since no multi-select for categories)
        color: 'blue',
    },
    {
        label: 'Delete',
        icon: Trash2,
        enabled: true,
        action: (category: Category) => {
            router.delete(`/admin/categories/${category.id}`);
        },
        class: 'btn-danger',
        displayOnMultipleSelect: true, // Always display delete option
        color: 'red',
    },
    {
        label: 'Add Subcategory',
        icon: Plus,
        enabled: true,
        action: (category) => {
            selectedCategory.value = category; // Reset selected category
            triggerSubcategoryManagement(category);
        },
        class: 'btn-primary',
        displayOnMultipleSelect: true, // Always display add option
        color: 'blue',
    },
]);

function handleCategoryEdit(category: Category) {
    selectedCategory.value = category;
    newCategory.value = { ...category };
    showForm.value = true;
}

function triggerSubcategoryManagement(category: Category) {
    newSubCategory.value = {
        id: 0,
        name: '',
        category_id: category.id,
        description: '',
        is_selected: false, // Ensure is_selected is initialized
    };
    selectedCategory.value = category;

    showSubcatForm.value = true;
}

function handleEditSubcategory(subcategory: SubCategory) {
    selectedSubCategory.value = subcategory;
    newSubCategory.value = { ...subcategory };
    showSubcatForm.value = true;
}

function updateToolbarItems(selectionValue: boolean) {
    SubcategoryEditToolbarItems.value.forEach((item) => {
        item.enabled = selectionValue;
    });
}

function selectSubCategory(
    subcategory: SubCategory,
    category: Category,
    value?: boolean,
) {
    selectedCategory.value = category;
    selectedSubCategory.value = subcategory;

    if (value) subcategory.is_selected = value;
    else subcategory.is_selected = !subcategory.is_selected;

    // Update the toolbar items based on selection
    updateToolbarItems(subcategory.is_selected);
}

function selectAllSubcategories(category: Category) {
    toggleAllSelection.value = !toggleAllSelection.value;

    category.subcategories.forEach((subcat) => {
        selectSubCategory(subcat, category, toggleAllSelection.value);
    });
}
</script>

<template>
    <div class="container mx-auto p-4">
        <h1 class="mb-4 text-2xl font-bold">Category Management</h1>

        <button
            @click="showForm = true"
            class="mb-4 rounded bg-blue-500 px-4 py-2 text-white"
        >
            Add New Category
        </button>

        <CategoryForm
            :category="newCategory"
            :show="showForm"
            @close="router.visit('/admin/categories')"
        />

        <SubCategoryForm
            :categories="props.categories"
            :subCategory="newSubCategory"
            :show="showSubcatForm"
            @close="showSubcatForm = false"
            @save="showSubcatForm = false"
        />

        <table
            class="min-w-full divide-y divide-gray-200 border border-black bg-white"
        >
            <thead>
                <tr>
                    <th class="w-1/2 text-left">Name</th>
                    <th class="w-1/2 text-right">Subcategories</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop through categories -->
                <tr v-for="category in props.categories" :key="category.id">
                    <td>
                        <div class="flex items-center text-left">
                            <span class="flex-1 p-6">{{ category.name }}</span>

                            <!-- Toolbar for Add/Delete -->
                            <FormToolbar
                                :toolbarItems="CategoryToolbarItems"
                                :targetObject="category"
                            />
                        </div>
                    </td>
                    <td>
                        <!-- SUBCATEGORIES display -->
                        <div class="flex flex-col">
                            <ul
                                v-if="
                                    category.subcategories &&
                                    category.subcategories.length > 0
                                "
                            >
                                <div class="flex items-center justify-between">
                                    <FormKit
                                        v-if="category.subcategories.length > 1"
                                        type="checkbox"
                                        v-model="toggleAllSelection"
                                        @click.stop="
                                            selectAllSubcategories(category)
                                        "
                                        class="mb-5"
                                        label="Select All"
                                    />

                                    <!--
                                    <div class="flex items-center justify-end">
                                        <button
                                            class="text-xxs cursor-pointer text-blue-500"
                                            @click="
                                                triggerSubcategoryManagement(
                                                    category,
                                                )
                                            "
                                        >
                                            <Plus class="h-4" />Add
                                        </button>
                                        <button
                                        v-if="!allSelected(category)"
                                            class="ml-2 text-xs text-blue-500"
                                        >
                                            <PencilLine class="h-4" />Edit
                                        </button>
                                        <button
                                            class="ml-2 cursor-pointer text-xs text-red-500"
                                            @click="
                                                handleSubcategoryDelete()
                                            "
                                        >
                                            <Trash2 class="h-4" />Delete
                                        </button>
                                    </div> -->
                                </div>
                                <li
                                    v-for="subcategory in category.subcategories"
                                    :key="subcategory.id"
                                    class="flex items-center"
                                >
                                    <div class="flex-1">
                                        <FormKit
                                            type="checkbox"
                                            v-model="subcategory.is_selected"
                                            class="mr-2 flex-1"
                                            :label="subcategory.name"
                                            @click="
                                                selectSubCategory(
                                                    subcategory,
                                                    category,
                                                )
                                            "
                                        />
                                    </div>
                                    <FormToolbar
                                        :toolbarItems="
                                            SubcategoryEditToolbarItems
                                        "
                                        :targetObject="subcategory"
                                        :display="subcategory.is_selected"
                                    />
                                </li>
                            </ul>
                            <span v-else class="flex justify-between">
                                <span class="flex-1 text-sm italic">
                                    No subcategories defined for this product
                                    category.
                                </span>
                                <!-- <button
                                    class="ml-2 text-xs text-blue-500"
                                    @click="
                                        triggerSubcategoryManagement(category)
                                    "
                                >
                                    <Plus class="h-4" />Add
                                </button> -->
                            </span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<style scoped>
.text-xxs {
    font-size: 0.75rem;
    line-height: 0.75rem;
}
</style>
