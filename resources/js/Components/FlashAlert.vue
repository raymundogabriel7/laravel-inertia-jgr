<script setup>
const props = defineProps({
    message: {
        type: String
    },
    success: {
        type: Boolean
    }
});
</script>

<template>
    <div v-show="props.success === true" class="bg-green-100 border-l-4 border-green-500 p-4 mb-4">
        <div class="flex items-center">
            <div class="ml-3">
            <p class="text-sm leading-5 text-green-700">
                {{props.message}}
            </p>
            </div>
        </div>
    </div>
    <div v-show="props.success === false" class="bg-red-100 border-l-4 border-red-500 p-4 mb-4">
        <div class="flex items-center">
            <div class="ml-3">
            <p class="text-sm leading-5 text-red-700">
                {{props.message}}
            </p>
            </div>
        </div>
    </div>
</template>
