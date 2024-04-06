<template>
  <div :class="[isMobile ? 'flex flex-col' : 'flex']">
    <MenuDesktop v-if="shouldShowSidebar && !isMobile" />
    <MenuMobile v-else-if="shouldShowSidebar && isMobile" />
    <router-view />
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, onBeforeUnmount } from "vue";
import { useRoute } from "vue-router";
import MenuDesktop from "./components/menu/screens/MenuDesktop.vue";
import MenuMobile from "./components/menu/screens/MenuMobile.vue";

const route = useRoute();
const shouldShowSidebar = computed(() => !route.meta.hideSideMenu);

const mobileWidth: number = 768;
const isMobile = ref(window.innerWidth < mobileWidth);

function checkIsMobile(): void {
  isMobile.value = window.innerWidth < mobileWidth;
}

onMounted(() => {
  window.addEventListener("resize", checkIsMobile);
});

onBeforeUnmount(() => {
  window.removeEventListener("resize", checkIsMobile);
});
</script>
