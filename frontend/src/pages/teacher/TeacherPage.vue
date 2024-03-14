<template>
  <ContainerPage>
    <TitlePage title="Professores" />

    <div class="flex flex-col">
      <div class="flex flex-col md:grid md:grid-cols-2 gap-3 md:gap-8">

        <div class="md:col-span-1">
          <CollapseContainer class="bg-[#222D32]" title="Adicionar Professor">
            <AddTeacher/>
          </CollapseContainer>
        </div>

        <div class="md:col-span-1">
          <CollapseContainer class="bg-[#222D32]" title="Outro Container">
            <h1>Conteúdo do Container 2</h1>
          </CollapseContainer>
        </div>

      </div>
    </div>
  </ContainerPage>
</template>

<script setup lang="ts">
import CollapseContainer from "@/components/CollapseContainer.vue";
import ContainerPage from "@/pages/ContainerPage.vue";
import TitlePage from "@/pages/TitlePage.vue";
import AddTeacher from "@/components/teacher/AddTeacher.vue"
</script>