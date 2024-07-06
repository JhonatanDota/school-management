<template>
  <div class="flex flex-col justify-center gap-2 items-center text-white"
    :class="[isMenuOpen ? 'h-24 md:h-28' : 'h-16 md:h-24']">
    <img v-if="storedUser.imageUrl" :src="storedUser.imageUrl" alt="" />

    <div class="flex flex-col items-center transition-all duration-500"
      :class="[isMenuOpen ? 'w-full' : 'w-0 h-0 overflow-hidden']">
      <h3 class="text-sm md:text-lg font-bold">{{ storedUser.name ? getFirstWord(storedUser.name) : "" }}</h3>
      <h4 class="text-xs md:text-base font-semibold">{{ 'unitName' }}</h4>
    </div>
  </div>
</template>

<script setup lang="ts">
import { defineProps } from "vue";
import userStore from "@/stores/userStore";
import getFirstWord from "@/utils/functions/string";

interface MenuUserProps {
  isMenuOpen: boolean;
}

const storedUser = userStore();

defineProps<MenuUserProps>();
</script>
