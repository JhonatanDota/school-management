<template>
  <div class="flex flex-col gap-3 p-6 rounded-md">
    <div @click="handleOpen" class="flex justify-between cursor-pointer">
        <h2 class="text-base font-bold text-white">{{ title }}</h2>
        <button>O</button>
    </div>

    <Collapse :when="open" class="transition-all duration-200">
      <slot></slot>
    </Collapse>
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import { defineProps } from "vue";
import { Collapse } from "vue-collapsed";

const open = ref(false);

function handleOpen(): void {
  open.value = !open.value;
}

interface SectionContainerProps {
  title: string;
}

defineProps<SectionContainerProps>();
</script>
