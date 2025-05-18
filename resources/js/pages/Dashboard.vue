<script setup >
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, router } from '@inertiajs/vue3';
import Pagination from '@/components/ui/DataTable/Pagination.vue';
import { ref } from 'vue';

const props = defineProps({
    posts: Object,
    filters: Object,
})

const breadcrumbs = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
]
const currentTab = ref(props.filters.status || '')

function handleTabChange(status) {
    currentTab.value = status
    router.get('/dashboard', { status }, {
        preserveState: true,
        preserveScroll: true,
    })
}

const tabs = [
    { label: 'All', value: '' },
    { label: 'Published', value: 'published' },
    { label: 'Unpublished', value: 'unpublished' },
    { label: 'Archived', value: 'archived' },
]

</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex gap-2 mt-6 ml-5 px-6">
            <button
                v-for="tab in tabs"
                :key="tab.value"
                @click="handleTabChange(tab.value)"
                :class="[
                    'px-4 py-2 rounded-full text-sm font-medium',
                    currentTab === tab.value
                        ? 'bg-primary text-white shadow'
                        : 'bg-muted text-muted-foreground hover:bg-muted/80'
                ]"
            >
                {{ tab.label }}
            </button>
        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 p-6">
            <div
                v-for="post in posts.data"
                :key="post.id"
                class="rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow hover:shadow-lg transition"
            >
                <img
                    v-if="post.thumbnail"
                    :src="post.thumbnail"
                    alt="Thumbnail"
                    class="w-full h-48 object-cover"
                />
                <div v-else class="w-full h-48 bg-gray-200 dark:bg-gray-700"></div>
                <div class="p-4 space-y-2">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                        {{ post.title }}
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2">
                        {{ post.excerpt }}
                    </p>
                    <!-- Tags -->
                    <div class="flex flex-wrap gap-1">
                        <span
                            v-for="tag in post.tags"
                            :key="tag.id"
                            class="px-2 py-0.5 bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400 rounded-full text-xs"
                        >
                            #{{ tag.name }}
                        </span>
                        <span
                            v-if="!post.tags?.length"
                            class="text-xs text-gray-400 dark:text-gray-500"
                        >
                            No tags
                        </span>
                    </div>
                    <div class="flex justify-between items-center text-xs text-gray-500 dark:text-gray-300 pt-2">
                        <div class="flex items-center gap-2">
                            <span>👤 {{ post.author?.name }}</span>
                        </div>
                        <span
                            class="px-2 py-0.5 rounded-full text-white text-xs"
                            :class="{
                                'bg-green-600': post.status === 'published',
                                'bg-gray-500': post.status !== 'published'
                            }"
                        >
                            {{ post.status }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-4/12 my-3 mx-auto">
        <Pagination  :pagination="posts.meta"  />
        </div>
    </AppLayout>
</template>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
