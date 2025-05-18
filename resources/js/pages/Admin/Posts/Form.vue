<script setup>
import AppLayout from '@/layouts/AppLayout.vue'
import { useForm } from '@inertiajs/vue3'
import { computed } from 'vue'

const props = defineProps({
    post: {
        type: Object,
        default: null,
    },
    categories: {
        type: Object,
        required: true
    },
    authors: {
        type: Object,
        required: true
    },
    tags: {
        type: Object,
        required: true
    }
})

const isEdit = computed(() => !!props.post)

const form = useForm({
    title: props.post?.title ?? '',
    category_id: props.post?.category_id ?? '',
    user_id: props.post?.user_id ?? '',
    excerpt: props.post?.excerpt ?? '',
    body: props.post?.body ?? '',
    status: props.post?.status ?? 'unpublished',
    thumbnail: null,
    tags: props.post?.tags?.map(tag => tag.id) ?? [],
    _method: isEdit.value ? 'PUT' : 'POST',

})

function handleSubmit() {
    if (isEdit.value) {
        form.post(route('posts.update', props.post.slug), {
            preserveScroll: true,
            preserveState: true,
            forceFormData: true,
        })
    } else {
        form.post(route('posts.store'), {
            preserveScroll: true,
            preserveState: true,
            forceFormData: true,
        })
    }
}
</script>

<template>
    <AppLayout>
        <div class="max-w-4xl mx-auto py-12">
            <div class="bg-white shadow-md rounded-xl p-8 space-y-6">
                <h1 class="text-3xl font-semibold text-gray-800 border-b pb-4">
                    {{ isEdit ? 'Edit Post' : 'Create Post' }}
                </h1>

                <form @submit.prevent="handleSubmit" class="space-y-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                            Title
                        </label>
                        <input
                            v-model="form.title"
                            id="title"
                            type="text"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            placeholder="Enter post title"
                        />
                        <p v-if="form.errors.title" class="text-sm text-red-600 mt-1">
                            {{ form.errors.title }}
                        </p>
                    </div>

                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-1">
                            Category
                        </label>
                        <select
                            v-model="form.category_id"
                            id="category"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        >
                            <option value="">Select Category</option>
                            <option
                                v-for="category in categories.data"
                                :key="category.id"
                                :value="category.id"
                            >
                                {{ category.name }}
                            </option>
                        </select>
                        <p v-if="form.errors.category_id" class="text-sm text-red-600 mt-1">
                            {{ form.errors.category_id }}
                        </p>
                    </div>

                    <div>
                        <label for="author" class="block text-sm font-medium text-gray-700 mb-1">
                            Author
                        </label>
                        <select
                            v-model="form.user_id"
                            id="author"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        >
                            <option value="">Select Author</option>
                            <option
                                v-for="author in authors.data"
                                :key="author.id"
                                :value="author.id"
                            >
                                {{ author.name }}
                            </option>
                        </select>
                        <p v-if="form.errors.user_id" class="text-sm text-red-600 mt-1">
                            {{ form.errors.user_id }}
                        </p>
                    </div>

                    <div>
                        <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-1">
                            Excerpt
                        </label>
                        <textarea
                            v-model="form.excerpt"
                            id="excerpt"
                            rows="2"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            placeholder="Enter post excerpt"
                        ></textarea>
                        <p v-if="form.errors.excerpt" class="text-sm text-red-600 mt-1">
                            {{ form.errors.excerpt }}
                        </p>
                    </div>

                    <div>
                        <label for="body" class="block text-sm font-medium text-gray-700 mb-1">
                            Content
                        </label>
                        <textarea
                            v-model="form.body"
                            id="body"
                            rows="6"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            placeholder="Enter post content"
                        ></textarea>
                        <p v-if="form.errors.body" class="text-sm text-red-600 mt-1">
                            {{ form.errors.body }}
                        </p>
                    </div>

                    <div>
                        <label for="thumbnail" class="block text-sm font-medium text-gray-700 mb-1">
                            Thumbnail
                        </label>
                        <input
                            type="file"
                            @input="form.thumbnail = $event.target.files[0]"
                            id="thumbnail"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            accept="image/*"
                        />
                        <p v-if="form.errors.thumbnail" class="text-sm text-red-600 mt-1">
                            {{ form.errors.thumbnail }}
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Tags
                        </label>
                        <div class="flex flex-wrap gap-2">
                            <label
                                v-for="tag in tags.data"
                                :key="tag.id"
                                class="inline-flex items-center"
                            >
                                <input
                                    type="checkbox"
                                    :value="tag.id"
                                    v-model="form.tags"
                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                >
                                <span class="ml-2">{{ tag.name }}</span>
                            </label>
                        </div>
                        <p v-if="form.errors.tags" class="text-sm text-red-600 mt-1">
                            {{ form.errors.tags }}
                        </p>
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                            Status
                        </label>
                        <select
                            v-model="form.status"
                            id="status"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        >
                            <option value="published">Published</option>
                            <option value="unpublished">Unpublished</option>
                        </select>
                        <p v-if="form.errors.status" class="text-sm text-red-600 mt-1">
                            {{ form.errors.status }}
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
