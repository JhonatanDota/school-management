<template>
  <div class="w-full flex justify-start items-center gap-2 p-4 hover:bg-purple-300 bg-green-800">
    <props.icon
      fill="white"
      color="red"
    />
    <h3 v-if="props.isMenuOpen" class="text-base font-bold text-white">
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
