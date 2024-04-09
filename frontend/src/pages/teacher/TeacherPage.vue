<template>
  <ContainerPage>
    <TitlePage title="Professores" />

    <div class="flex flex-col gap-3">
      <div class="flex flex-col md:grid md:grid-cols-2 gap-3 md:gap-8">
        <div class="md:col-span-1">
          <CollapseContainer class="bg-[#222D32]" title="Adicionar Professor">
            <AddTeacher />
          </CollapseContainer>
        </div>

        <div class="md:col-span-1">
          <CollapseContainer class="bg-[#222D32]" title="Outro Container">
            <h1>Conteúdo do Container 2</h1>
          </CollapseContainer>
        </div>
      </div>

      <DataTable :thList="teacherThList" :tdKeys="teacherTdKeys" :data="[]" :loadingData="loadingData"/>
    </div>
  </ContainerPage>
</template>

<script setup lang="ts">
import { ref, onMounted } from "vue";
import CollapseContainer from "@/components/CollapseContainer.vue";
import ContainerPage from "@/pages/ContainerPage.vue";
import TitlePage from "@/pages/TitlePage.vue";
import AddTeacher from "@/components/teacher/AddTeacher.vue";
import DataTable from "@/components/table/DataTable.vue";
import { TeacherModel, teacherTdKeys, teacherThList } from "@/models/TeacherModel";
import { getTeachers, TeacherPagination } from "@/requests/teacherRequests";

const loadingData = ref<boolean>(true);
const teachers = ref<TeacherModel[]>([]);

onMounted(async () => {
  try {
    const teachersResponse = await getTeachers();
    const responseData: TeacherPagination = teachersResponse.data;

    teachers.value = responseData.data;
    loadingData.value = false;
  } catch {
    //
  }
});
</script>
