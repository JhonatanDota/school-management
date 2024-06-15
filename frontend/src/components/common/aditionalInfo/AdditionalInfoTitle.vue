<template>
    <p class="text-base md:text-xl font-semibold text-green-600">{{ text }}</p>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';

interface AdditionalInfoTitleProps {
    text: string;
}

defineProps<AdditionalInfoTitleProps>()
</script>