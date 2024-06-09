<template>
    <button type="submit"
        class="text-sm md:text-lg self-end p-3 md:p-4 bg-green-600 text-white font-bold rounded-md mt-2">
        {{ text }}
    </button>
</template>

<script setup lang="ts">
import { defineProps } from "vue";

interface SubmitButtonProps {
    text: string;
}

defineProps<SubmitButtonProps>();
</script>