<script setup>
import { Link } from '@inertiajs/vue3'

const props = defineProps({
    pagination:Object
})
</script>

<template>
    <div class="flex justify-between items-center mt-4">
        <template v-for="link in pagination.links" :key="link.label">
            <Link
                preserve-scroll
                :href="link.url ?? ''"
                v-html="link.label"
                class="flex items-center justify-center px-3 py-2 text-sm rounded-lg text-gray-600"
                :class="{ 'bg-gray-200': link.active, '!text-gray-300': !link.url }"
            />
        </template>
    </div>
</template>

<style scoped>

</style>
