<template>
  <div
    class="relative h-screen flex flex-col bg-black transition-all duration-300"
    :class="[menuOpen ? 'w-44' : 'w-16']"
  >
    <button @click="handleMenu" class="text-red-400 absolute top-0 right-2">
      A
    </button>
    <div class="flex flex-col gap-6">
      <MenuItemVue name="abada" :icon="CapIcon" />
      <MenuItemVue name="Xd" :icon="CapIcon" />
      <MenuItemVue name="asd" :icon="CapIcon" />
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import MenuItemVue from "./MenuItem.vue";
import CapIcon from "@/icons/CapIcon.vue";

const menuOpen = ref(true);

function handleMenu(): void {
  menuOpen.value = !menuOpen.value;
}
</script>
