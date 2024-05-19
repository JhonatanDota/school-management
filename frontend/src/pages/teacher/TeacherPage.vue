<template>
  <ContainerPage>
    <TitlePage title="Professores" />

    <div class="flex flex-col gap-3">
      <div class="flex flex-col md:grid md:grid-cols-2 gap-3 md:gap-8">
        <div class="md:col-span-1">
          <CollapseContainer class="bg-[#222D32]" title="Adicionar Professor">
            <AddTeacher :onAdd="setNewTeacher" />
          </CollapseContainer>
        </div>

        <div class="md:col-span-1">
          <CollapseContainer class="bg-[#222D32]" title="Outro Container">
            <h1>Conteúdo do Container 2</h1>
          </CollapseContainer>
        </div>
      </div>

      <DataTable :thList="teacherThList" :tdKeys="teacherTdKeys" :data="teachers" :isLoading="loadingData" />

      <DataTablePagination class="m-auto" v-if="pagination" :pagination="pagination" @setParams="setParams" />
    </div>
  </ContainerPage>
</template>

<script setup lang="ts">
import { ref, watch } from "vue";
import { LocationQuery, useRouter } from 'vue-router';
import CollapseContainer from "@/components/CollapseContainer.vue";
import ContainerPage from "@/pages/ContainerPage.vue";
import TitlePage from "@/pages/TitlePage.vue";
import AddTeacher from "@/components/teacher/AddTeacher.vue";
import DataTable from "@/components/table/DataTable.vue";
import DataTablePagination from "@/components/table/DataTablePagination.vue";
import { ThModel } from "@/models/DataTableModel";
import { TeacherModel } from "@/models/TeacherModel";
import { getTeachers, TeacherPagination } from "@/requests/teacherRequests";
import PaginationModel from "@/models/PaginationModel";

interface Params {
  page?: number;
}

const teacherTdKeys: string[] = ["id", "name", "email", "created_at"];

const teacherThList: ThModel[] = [
  { text: "Identificador" },
  { text: "Nome" },
  { text: "Email" },
  { text: "Criado em" },
];

const router = useRouter();
const loadingData = ref<boolean>(true);
const teachers = ref<TeacherModel[]>([]);
const pagination = ref<PaginationModel>();
const params = ref<Params>(router.currentRoute.value.query);

watch(params, async function () {
  getTeachersData(params.value);
  updateRouteQueryParams(params.value);
}, { immediate: true });

function setParams(newParams: Params): void {
  params.value = { ...params.value, ...newParams };
}

function updateRouteQueryParams(params: Params): void {
  router.push({ query: params as LocationQuery });
}

async function getTeachersData(params: Params): Promise<void> {
  loadingData.value = true;

  try {
    const response = await getTeachers(params);
    const responseData: TeacherPagination = response.data;

    teachers.value = responseData.data;
    pagination.value = response.data as PaginationModel;
  } catch {
    //
  } finally {
    loadingData.value = false;
  }
}

function setNewTeacher(teacher: TeacherModel) {
  teachers.value = [teacher, ...teachers.value];
}

</script>
