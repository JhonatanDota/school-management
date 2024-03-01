<template>
  <div
    class="relative h-screen flex flex-col gap-6 pt-5 bg-black"
    :class="[isMenuOpen ? 'w-32 md:w-48' : 'w-16 md:w-24']"
  >
    <button @click="handleMenu" class="absolute w-6 h-5 top-0 right-0">
      <MenuStripesIcon fill="white" />
    </button>

    <MenuUser name="Jhonatan" unitName="Super Admin" :isMenuOpen="isMenuOpen" />
    <div class="flex flex-col items-start gap-6 md:gap-10">
      <router-link class="w-full" to="/">
        <MenuItem name="Home" :icon="HomeIcon" :isMenuOpen="isMenuOpen" />
      </router-link>

      <router-link class="w-full" to="/classes">
        <MenuItem
          name="Turmas"
          :icon="StudentCapIcon"
          :isMenuOpen="isMenuOpen"
        />
      </router-link>

      <router-link class="w-full" to="/students">
        <MenuItem
          name="Alunos"
          :icon="ClassRoomIcon"
          :isMenuOpen="isMenuOpen"
        />
      </router-link>
    </div>
  </div>

  <router-view></router-view>
</template>

<script setup lang="ts">
import { ref } from "vue";
import MenuStripesIcon from "@/icons/MenuStripesIcon.vue";
import MenuUser from "@/components/menu/MenuUser.vue";
import MenuItem from "@/components/menu/MenuItem.vue";
import HomeIcon from "@/icons/HomeIcon.vue";
import StudentCapIcon from "@/icons/StudentCapIcon.vue";
import ClassRoomIcon from "@/icons/ClassRoomIcon.vue";

const isMenuOpen = ref(true);

function handleMenu(): void {
  isMenuOpen.value = !isMenuOpen.value;
}
</script>
