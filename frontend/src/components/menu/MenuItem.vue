<template>
  <div
    class="w-full flex justify-center items-center gap-2 md:gap-4 p-3 md:p-5 hover:bg-[#632C96] transition-colors duration-100 cursor-pointer">
    <h3 v-if="isMenuOpen" class="text-base md:text-lg font-bold text-white">
      {{ name }}
    </h3>
    <icon v-else fill="white" />
  </div>
</template>

<script setup lang="ts">
import { Component, defineProps } from "vue";

interface MenuItemProps {
  name: string;
  icon: Component;
  isMenuOpen: boolean;
}

defineProps<MenuItemProps>();
</script>
