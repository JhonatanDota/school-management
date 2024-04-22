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

      <DataTable
        :thList="teacherThList"
        :tdKeys="teacherTdKeys"
        :data="teachers"
        :isLoading="loadingData"
      />

      <DataTablePagination
        class="m-auto"
        v-if="pagination"
        :pagination="pagination"
        @changePage="changePage"
      />
    </div>
  </ContainerPage>
</template>

<script setup lang="ts">
import { ref, onMounted } from "vue";
import { useRouter } from 'vue-router';
import CollapseContainer from "@/components/CollapseContainer.vue";
import ContainerPage from "@/pages/ContainerPage.vue";
import TitlePage from "@/pages/TitlePage.vue";
import AddTeacher from "@/components/teacher/AddTeacher.vue";
import DataTable from "@/components/table/DataTable.vue";
import DataTablePagination from "@/components/table/DataTablePagination.vue";
import {
  TeacherModel,
  teacherTdKeys,
  teacherThList,
} from "@/models/TeacherModel";
import { getTeachers, TeacherPagination } from "@/requests/teacherRequests";
import PaginationModel from "@/models/PaginationModel";

const router = useRouter();
const loadingData = ref<boolean>(true);
const teachers = ref<TeacherModel[]>([]);
const pagination = ref<PaginationModel>();

onMounted(function(): void {getTeachersData(); console.log(router.currentRoute.value.query)});

function changePage(page: number): void {
  getTeachersData(page);
  updateRouteQueryParams(page);
}

function updateRouteQueryParams(page: number):void{
  router.push({ query: { page } });
}

async function getTeachersData(page?: number): Promise<void> {
  loadingData.value = true;

  try {
    const response = await getTeachers(page);
    const responseData: TeacherPagination = response.data;

    teachers.value = responseData.data;
    pagination.value = response.data as PaginationModel;
  } catch {
    //
  } finally {
    loadingData.value = false;
  }
}

</script>
