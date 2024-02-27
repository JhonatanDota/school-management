<template>
  <div class="flex flex-col justify-center gap-2 h-24 items-center text-white">
    <img v-if="props.img" src="{{  }}" alt="" />
    <UserIcon v-else class="h-8 w-8" fill="white" />

    <div v-if="props.isMenuOpen" class="flex flex-col items-center">
      <h3 class="text-sm font-bold">{{ props.name }}</h3>
      <h4 class="text-xs font-semibold">{{ props.unitName }}</h4>
    </div>
  </div>
</template>

<script setup lang="ts">
import { defineProps } from "vue";
import UserIcon from "@/icons/UserIcon.vue";

interface MenuUserProps {
  name: string;
  unitName: string;
  img?: string;
  isMenuOpen: boolean;
}

const props: MenuUserProps = defineProps<MenuUserProps>();
</script>
