<template>
  <div class="flex items-center gap-2 p-3 hover:bg-purple-300 transition-colors">
    <props.icon class="w-6 h-6" fill="white" color="red" />
    <h3 class="font-bold text-white">
      {{ props.name }}
    </h3>
  </div>
</template>

<script setup lang="ts">
import { Component, defineProps } from "vue";

interface MenuItemProps {
  name: string;
  icon: Component;
}

const props: MenuItemProps = defineProps<MenuItemProps>();
</script>


MOVER A LOGICA DA FACTORY PARA O SEEDER