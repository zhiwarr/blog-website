<script setup>
import DataTable from '@/components/ui/DataTable/Datatable.vue'
import AppLayout from '@/layouts/AppLayout.vue'
import Pagination from '@/components/ui/DataTable/Pagination.vue';
import {  Pencil, Trash2 } from 'lucide-vue-next';
import { Link, router, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    categories: Object,
})

const page = usePage()
const flash = computed(() => page.props.flash)
const columns = [
    { key: 'id', label: 'ID' },
    { key: 'name', label: 'Name' },
]
function handleDelete(id) {
    if (confirm('Are you sure you want to delete this category?')) {
        router.delete(route('categories.destroy', id))
    }
}
</script>

<template>
    <AppLayout>
        <div class="container py-10 mx-auto">
            <div class="mb-4">
                <Link
                    :href="route('categories.create')"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                >
                    + New Category
                </Link>
            </div>
            <div v-if="flash.success" class="mb-4 text-green-600 bg-green-100 border border-green-300 p-3 rounded">
                {{ flash.success }}
            </div>

            <div v-if="flash.error" class="mb-4 text-red-600 bg-red-100 border border-red-300 p-3 rounded">
                {{ flash.error }}
            </div>
            <DataTable
                :columns="columns"
                :items="categories"
            >
                <template #actions="{ item }">
                    <div class="flex justify-center items-center">

                    <Link
                        :href="route('categories.edit', item.slug)"
                        class="text-blue-500 hover:text-blue-700"
                    >
                        <Pencil class="w-6 h-6" />
                    </Link>
                    <button class="text-red-500 ml-2" @click="handleDelete(item.slug)"> <Trash2 class="w-6 h-6" /></button>
                    </div>
                </template>
            </DataTable>
            <Pagination :pagination="categories.meta"></Pagination>
        </div>
    </AppLayout>
</template>
