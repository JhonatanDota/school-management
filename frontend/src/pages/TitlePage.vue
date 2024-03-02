<template>
  <h1>{{ title }}</h1>
</template>

<script setup lang="ts">
import { defineProps } from "vue";

interface TitlePageProps {
  title: string;
}

defineProps<TitlePageProps>();
</script>
