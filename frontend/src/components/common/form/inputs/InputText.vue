<template>
    <input
        class="text-base md:text-xl font-semibold bg-[#7745a5a8] w-full p-2 md:p-4 text-white focus:outline-none rounded-md"
        type="text" :id="id" :value="modelValue" @input="updateValue" autocomplete="off" />
</template>

<script setup lang="ts">
import { defineProps, defineEmits } from 'vue';

interface InputTextProps {
    id: string,
    modelValue?: string;
}

defineProps<InputTextProps>();

const emit = defineEmits(['update:modelValue']);

function updateValue(event: Event) {
    emit('update:modelValue', (event.target as HTMLInputElement).value);
}
</script>