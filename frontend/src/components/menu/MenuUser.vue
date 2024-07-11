<template>
  <div v-if="!storedUser.filling" class="flex flex-col justify-center gap-2 items-center text-white"
    :class="[isMenuOpen ? 'h-24 md:h-28' : 'h-16 md:h-24']">

    <img class="w-14 md:w-16 h-14 md:h-16 rounded-full" :src="storedUser.user.imageUrl ?? userIcon" />

    <div class="flex flex-col items-center transition-all duration-500"
      :class="[isMenuOpen ? 'w-full' : 'w-0 h-0 overflow-hidden']">
      <h3 class="text-sm md:text-lg font-bold">{{ storedUser.user.name ? getFirstWord(storedUser.user.name) : "" }}</h3>
    </div>
  </div>
  <MenuUserSkeleton v-else />
</template>

<script setup lang="ts">
import { defineProps } from "vue";
import userStore from "@/stores/userStore";
import MenuUserSkeleton from "@/skeletons/MenuUserSkeleton.vue"
import getFirstWord from "@/utils/functions/string";
import userIcon from "@/assets/images/user-icon.svg"

interface MenuUserProps {
  isMenuOpen: boolean;
}

const storedUser = userStore();

defineProps<MenuUserProps>();
</script>
