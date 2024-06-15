<template>
    <p class="text-base md:text-xl font-semibold text-white">{{ text }}</p>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';

interface AdditionalInfoValueProps {
    text: string;
}

defineProps<AdditionalInfoValueProps>()
</script>