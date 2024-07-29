<template>
  <div class="sticky h-screen top-0 flex flex-col gap-6 pt-5 bg-[#222D32] transition-all duration-300"
    :class="[isMenuOpen ? 'w-48' : 'w-24']">
    <button @click="handleMenu" class="absolute w-6 h-5 top-0 right-0">
      <MenuStripesIcon fill="white" />
    </button>

    <button @click="logout" class="absolute w-6 h-5 bottom-8 left-1/2 -translate-x-1/2">
      <LogoutIcon fill="white" />
    </button>

    <MenuUser :isMenuOpen="isMenuOpen" />

    <hr class="w-full bg-[#7745a5c2] h-2 md:h-3 border-none" />

    <div class="flex flex-col items-start gap-6 md:gap-10">
      <router-link class="w-full" active-class="bg-[#632C96]" to="/home">
        <MenuItem name="Home" :icon="HomeIcon" :isMenuOpen="isMenuOpen" />
      </router-link>

      <router-link class="w-full" active-class="bg-[#632C96]" to="/courses">
        <MenuItem name="Cursos" :icon="CourseIcon" :isMenuOpen="isMenuOpen" />
      </router-link>

      <router-link class="w-full" active-class="bg-[#632C96]" to="/teachers">
        <MenuItem name="Professores" :icon="TeacherIcon" :isMenuOpen="isMenuOpen" />
      </router-link>

      <router-link class="w-full" active-class="bg-[#632C96]" to="/classes">
        <MenuItem name="Turmas" :icon="StudentCapIcon" :isMenuOpen="isMenuOpen" />
      </router-link>

      <router-link class="w-full" active-class="bg-[#632C96]" to="/students">
        <MenuItem name="Alunos" :icon="ClassRoomIcon" :isMenuOpen="isMenuOpen" />
      </router-link>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import { useRouter } from "vue-router";
import { logout as logoutRequest } from "@/requests/authRequests";
import { cleanStoredLoginData } from "@/functions/auth";
import MenuStripesIcon from "@/icons/MenuStripesIcon.vue";
import MenuUser from "@/components/menu/MenuUser.vue";
import MenuItem from "@/components/menu/MenuItem.vue";
import HomeIcon from "@/icons/HomeIcon.vue";
import CourseIcon from "@/icons/CourseIcon.vue";
import TeacherIcon from "@/icons/TeacherIcon.vue";
import StudentCapIcon from "@/icons/StudentCapIcon.vue";
import ClassRoomIcon from "@/icons/ClassRoomIcon.vue";
import LogoutIcon from "@/icons/LogoutIcon.vue";

const router = useRouter();
const isMenuOpen = ref(true);

function handleMenu(): void {
  isMenuOpen.value = !isMenuOpen.value;
}

async function logout(): Promise<void> {
  try {
    await logoutRequest();
    cleanStoredLoginData();
    router.push("/");
  } catch {
    //
  }
}
</script>
