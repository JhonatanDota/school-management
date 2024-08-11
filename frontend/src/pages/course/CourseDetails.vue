<template>
  <ContainerPage>
    <div class="w-7 h-7 md:w-10 md:h-10">
      <button @click="backToCoursesPage">
        <CircleArrowUp fill="#7745a5c2" class="w-full -rotate-90"/>
      </button>
    </div>

      <TitlePage title="Detalhes do Curso" />
    </ContainerPage>
</template>

<script setup lang="ts">
import { useRouter } from "vue-router";
import ContainerPage from "../ContainerPage.vue";
import TitlePage from "../TitlePage.vue";
import CircleArrowUp from "@/icons/CircleArrowUp.vue";

const router = useRouter();

function backToCoursesPage(): void{
  router.push("/courses");
}
</script>