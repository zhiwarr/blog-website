<script setup>
import AppLayout from '@/layouts/AppLayout.vue'
import { useForm } from '@inertiajs/vue3'
import { computed } from 'vue'

const props = defineProps({
    category: {
        type: Object,
        default: null,
    },
})

const isEdit = computed(() => !!props.category)

const form = useForm({
    name: props.category?.name ?? '',
})

function handleSubmit() {
    if (isEdit.value) {
        form.put(route('categories.update', props.category.slug))
    } else {
        form.post(route('categories.store'))
    }
}
</script>

<template>
    <AppLayout>
        <div class="max-w-2xl mx-auto py-12">
            <div class="bg-white shadow-md rounded-xl p-8 space-y-6">
                <h1 class="text-3xl font-semibold text-gray-800 border-b pb-4">
                    {{ isEdit ? 'Edit Category' : 'Create Category' }}
                </h1>

                <form @submit.prevent="handleSubmit" class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                            Category Name
                        </label>
                        <input
                            v-model="form.name"
                            id="name"
                            type="text"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            placeholder="Enter category name"
                        />
                        <p v-if="form.errors.name" class="text-sm text-red-600 mt-1">
                            {{ form.errors.name }}
                        </p>
                    </div>

                    <div class="pt-2">
                        <button
                            type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-4 rounded-lg transition duration-150 ease-in-out disabled:opacity-50"
                            :disabled="form.processing"
                        >
                            <span v-if="form.processing">Processing...</span>
                            <span v-else>{{ isEdit ? 'Update' : 'Create' }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
