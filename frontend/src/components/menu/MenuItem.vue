<template>
  <div
    class="w-full flex items-center gap-2 md:gap-4 p-3 md:p-5 hover:bg-[#632C96] transition-colors duration-100 cursor-pointer"
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
