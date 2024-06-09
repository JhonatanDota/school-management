<template>
    <label class="inline-flex items-center cursor-pointer">
        <input type="checkbox" :id="id" class="sr-only peer" :value="modelValue" @input="updateValue" :checked="modelValue">
        <div
            class="relative w-11 h-6 bg-gray-500 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
        </div>
    </label>
</template>

<script setup lang="ts">
import { defineProps, defineEmits } from 'vue';

interface InputCheckboxProps {
    id: string;
    modelValue: boolean;
}

defineProps<InputCheckboxProps>();

const emit = defineEmits(['update:modelValue']);

function updateValue(event: Event): void {
    emit('update:modelValue', (event.target as HTMLInputElement).checked);
}
</script>