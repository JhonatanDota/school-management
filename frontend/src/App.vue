<template>
  <div v-if="routeExists && route.path !== '/'" class="flex">
    <SideMenu />
  </div>
  <router-view />
</template>

<script setup lang="ts">
import { useRoute } from "vue-router";
import SideMenu from "./components/menu/SideMenu.vue";

const route = useRoute();
const routeExists = route.matched.length > 0;
</script>
