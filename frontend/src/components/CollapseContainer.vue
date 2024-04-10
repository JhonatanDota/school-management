<template>
  <div class="flex flex-col gap-3 p-6 rounded-md">
    <div
      @click="handleOpen"
      class="flex justify-between items-center cursor-pointer"
    >
      <h2 class="text-base md:text-xl font-bold text-white">{{ title }}</h2>
      <button class="w-5 h-5 md:w-10 md:h-10">
        <CircleArrowUp
          fill="white"
          class="transition-all duration-300"
          :class="[open ? '' : '-rotate-180']"
        />
      </button>
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
import CircleArrowUp from "@/icons/CircleArrowUp.vue";

const open = ref(false);

function handleOpen(): void {
  open.value = !open.value;
}

interface SectionContainerProps {
  title: string;
}

defineProps<SectionContainerProps>();
</script>
