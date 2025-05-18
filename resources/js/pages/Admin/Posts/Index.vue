<script setup>
import DataTable from '@/components/ui/DataTable/Datatable.vue'
import AppLayout from '@/layouts/AppLayout.vue'
import Pagination from '@/components/ui/DataTable/Pagination.vue';
import { Pencil, Trash2 } from 'lucide-vue-next';
import { Link, router, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    posts: Object,
})

const page = usePage()
const flash = computed(() => page.props.flash)

const columns = [
    { key: 'id', label: 'ID' },
    { key: 'thumbnail', label: 'Thumbnail' },
    { key: 'title', label: 'Title' },
    { key: 'category.name', label: 'Category', relation: true },
    { key: 'tags', label: 'Tags', relation: true },
    { key: 'author.name', label: 'Author', relation: true },
    { key: 'status', label: 'Status' },
]

function handleDelete(id) {
    if (confirm('Are you sure you want to delete this post?')) {
        router.delete(route('posts.destroy', id))
    }
}
</script>

<template>
    <AppLayout>
        <div class="container py-10 mx-auto">
            <div class="mb-4">
                <Link
                    :href="route('posts.create')"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                >
                    + New Post
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
                :items="posts"
            >
                <template #thumbnail="{ item }">
                    <div class="flex justify-center">
                        <img
                            v-if="item.thumbnail"
                            :src="item.thumbnail"
                            :alt="item.title"
                            class="w-16 h-16 object-cover rounded"
                        />
                        <div v-else class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center text-gray-500 text-xs">
                            No image
                        </div>
                    </div>
                </template>

                <template #title="{ value }">
                    <div class="max-w-xs truncate">{{ value }}</div>
                </template>

                <template #category.name="{ value }">
                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">
                        {{ value }}
                    </span>
                </template>

                <template #tags="{ item }">
                    <div class="flex flex-wrap gap-1">
                        <span
                            v-for="tag in item.tags"
                            :key="tag.id"
                            class="px-2 py-1 bg-gray-100 text-gray-600 rounded-full text-xs"
                        >
                            {{ tag.name }}
                        </span>
                        <span v-if="!item.tags?.length" class="text-gray-400 text-xs">
                            No tags
                        </span>
                    </div>
                </template>

                <template #author.name="{ item }">
                    <div class="flex items-center gap-2">
                        <img
                            v-if="item.author?.avatar"
                            :src="item.author.avatar"
                            :alt="item.author.name"
                            class="w-8 h-8 rounded-full object-cover"
                        />
                        <span class="text-sm">{{ item.author?.name }}</span>
                    </div>
                </template>

                <template #status="{ value }">
                    <span
                        :class="{
                            'bg-green-100 text-green-800': value === 'published',
                            'bg-yellow-100 text-yellow-800': value === 'unpublished'
                        }"
                        class="px-2 py-1 rounded-full text-xs"
                    >
                        {{ value }}
                    </span>
                </template>

                <template #actions="{ item }">
                    <div class="flex justify-center items-center gap-2">
                        <Link
                            :href="route('posts.edit', item.slug)"
                            class="text-blue-500 hover:text-blue-700 transition-colors"
                        >
                            <Pencil class="w-5 h-5" />
                        </Link>
                        <button
                            @click="handleDelete(item.slug)"
                            class="text-red-500 hover:text-red-700 transition-colors"
                        >
                            <Trash2 class="w-5 h-5" />
                        </button>
                    </div>
                </template>
            </DataTable>

            <div class="mt-4">
                <Pagination :pagination="posts.meta" />
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
.container {
    max-width: 1200px;
}
</style>
