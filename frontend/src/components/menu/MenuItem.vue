<template>
  <div
    class="w-full flex items-center gap-2 md:gap-3 p-3 md:p-6 hover:bg-purple-300 bg-green-800 cursor-pointer"
    :class="[props.isMenuOpen ? 'justify-start' : 'justify-center']"
  >
    <props.icon fill="white" color="red" />
    <h3
      v-if="props.isMenuOpen"
      class="text-base md:text-lg font-bold text-white"
    >
      {{ props.name }}
    </h3>
  </div>
</template>

<script setup lang="ts">
import { Component, defineProps } from "vue";

interface MenuItemProps {
  name: string;
  icon: Component;
  isMenuOpen: boolean;
}

const props: MenuItemProps = defineProps<MenuItemProps>();
</script>
