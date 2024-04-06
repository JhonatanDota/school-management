<template>
  <button @click="handleMenu" class="fixed w-6 h-5 top-3 right-3 z-20">
    <MenuStripesIcon :fill="isMenuOpen ? 'white' : 'black'" />
  </button>

  <div
    class="fixed p-4 bg-[#222D32] transition-all ease-in-out duration-200 self-end z-10"
    :class="[
      isMenuOpen ? 'w-1/2 opacity-100' : 'w-0 opacity-0 overflow-hidden',
    ]"
  >
    <MenuUser name="Jhonatan" unitName="Super Admin" :isMenuOpen="true" />

    <hr class="w-full bg-[#7745a5c2] h-1 my-2 border-none" />

    <div class="flex flex-col items-start gap-6">
      <router-link class="w-full" active-class="bg-[#632C96]" to="/home">
        <MenuItem name="Home" :icon="HomeIcon" :isMenuOpen="true" />
      </router-link>

      <router-link class="w-full" active-class="bg-[#632C96]" to="/teachers">
        <MenuItem name="Instrutores" :icon="TeacherIcon" :isMenuOpen="true" />
      </router-link>

      <router-link class="w-full" active-class="bg-[#632C96]" to="/classes">
        <MenuItem name="Turmas" :icon="StudentCapIcon" :isMenuOpen="true" />
      </router-link>

      <router-link class="w-full" active-class="bg-[#632C96]" to="/students">
        <MenuItem name="Alunos" :icon="ClassRoomIcon" :isMenuOpen="true" />
      </router-link>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import MenuStripesIcon from "@/icons/MenuStripesIcon.vue";
import MenuUser from "@/components/menu/MenuUser.vue";
import MenuItem from "@/components/menu/MenuItem.vue";
import HomeIcon from "@/icons/HomeIcon.vue";
import TeacherIcon from "@/icons/TeacherIcon.vue";
import StudentCapIcon from "@/icons/StudentCapIcon.vue";
import ClassRoomIcon from "@/icons/ClassRoomIcon.vue";

const isMenuOpen = ref(false);

function handleMenu(): void {
  isMenuOpen.value = !isMenuOpen.value;
}
</script>
