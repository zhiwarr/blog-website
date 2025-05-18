<script setup>
const props = defineProps({
    columns: Array,
    items: Object,
})

const getNestedValue = (obj, path) => {
    return path.split('.').reduce((value, key) => {
        return value ? value[key] : null;
    }, obj);
}
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
                    <slot
                        :name="col.key"
                        :item="item"
                        :value="getNestedValue(item, col.key)"
                    >
                        <template v-if="col.relation">
                            {{ getNestedValue(item, col.key) }}
                        </template>
                        <template v-else>
                            {{ item[col.key] }}
                        </template>
                    </slot>
                </td>
                <td class="text-center p-2 border">
                    <slot name="actions" :item="item" />
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>
