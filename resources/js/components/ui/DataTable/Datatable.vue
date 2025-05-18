<script setup>

const props = defineProps({
    columns: Array,
    items: Object,
})


</script>

<template>
    <div>
        <table class="min-w-full text-sm border">
            <thead>
            <tr class="bg-gray-100">
                <th
                    v-for="col in columns"
                    :key="col.key"
                    class="text-left p-2 border"
                >
                    {{ col.label }}
                </th>
                <th class="text-center p-2 border">Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in items.data" :key="item.id">
                <td
                    v-for="col in columns"
                    :key="col.key"
                    class="p-2 border"
                >
                    {{ item[col.key] }}
                </td>
                <td class="text-center p-2 border">
                    <slot name="actions" :item="item" />
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>
