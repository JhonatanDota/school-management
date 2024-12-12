<template>
    <VueFinalModal class="flex justify-center items-center"
        content-class="flex flex-col gap-2 md:gap-4 p-3 md:p-6 bg-[#222D32] rounded-md relative" v-model="isVisible"
        @update:modelValue="closeModal" overlayTransition="vfm-fade" contentTransition="vfm-fade">
        <h1 class="text-base md:text-xl uppercase font-bold text-yellow-500">{{ title }}</h1>
        <button @click="closeModal" class="absolute top-1 right-1">
            <XIcon class="w-7 md:w-10 h-7 md:h-10 fill-red-600" />
        </button>
        <slot></slot>
    </VueFinalModal>
</template>

<script setup lang="ts">
import { ref, defineProps, defineEmits, watch } from 'vue';
import { VueFinalModal } from 'vue-final-modal';
import XIcon from '@/icons/XIcon.vue';

interface BaseModalProps {
    title: string;
    modelValue: boolean;
}

const props = defineProps<BaseModalProps>();
const emit = defineEmits<{
    (event: 'update:modelValue', value: boolean): void;
}>();

const isVisible = ref(props.modelValue);

watch(() => props.modelValue, (newValue) => {
    isVisible.value = newValue;
});

function closeModal(): void {
    emit('update:modelValue', false);
}
</script>
