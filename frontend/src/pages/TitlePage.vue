<template>
  <h1 class="text-base font-bold text-[#222D32] uppercase">{{ title }}</h1>
</template>

<script setup lang="ts">
import { defineProps } from "vue";

interface TitlePageProps {
  title: string;
}

defineProps<TitlePageProps>();
</script>
