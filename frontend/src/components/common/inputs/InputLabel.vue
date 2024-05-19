<template>
  <label class="text-base md:text-xl font-semibold text-green-600" :for="track">{{ text }}</label>
</template>

<script setup lang="ts">
import { defineProps } from "vue";

interface InputLabelProps {
  track: string;
  text: string;
}

defineProps<InputLabelProps>();
</script>
