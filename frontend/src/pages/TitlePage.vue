<template>
  <h1 class="text-base md:text-2xl font-bold text-[#222D32] uppercase">{{ title }}</h1>
</template>

<script setup lang="ts">
import { defineProps } from "vue";

interface TitlePageProps {
  title: string;
}

defineProps<TitlePageProps>();
</script>
