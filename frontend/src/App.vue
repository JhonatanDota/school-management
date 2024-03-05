<template>
  <div class="flex">
    <SideMenu v-if="shouldShowSidebar" />
    <router-view />
  </div>

</template>

<script setup lang="ts">
import { computed } from "vue"
import SideMenu from "./components/menu/SideMenu.vue";
import { useRoute } from "vue-router"

const route = useRoute();
const shouldShowSidebar = computed(() => !route.meta.hideSideMenu);

</script>
