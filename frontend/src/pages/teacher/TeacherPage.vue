<template>
  <ContainerPage>
    <TitlePage title="Professores" />
    <div class="flex flex-col gap-3">
      <div class="flex flex-col md:grid md:grid-cols-2 gap-3 md:gap-8">
        <div class="md:col-span-1">
          <CollapseContainer class="bg-[#222D32]" title="Adicionar Professor" ref="collapseAddTeacherChild">
            <AddTeacher :onAdd="onAddTeacher" />
          </CollapseContainer>
        </div>

        <div class="md:col-span-1">
          <CollapseContainer class="bg-[#222D32]" title="Informações do Professor" ref="collapseEditTeacherChild">
            <div class="flex flex-col gap-3" v-if="selectedTeacher">
              <EditTeacher :teacher="selectedTeacher" :onEdit="onEditTeacher">
                <AdditionalInfoTeacher :teacher="selectedTeacher" />
              </EditTeacher>
            </div>
            <h1 v-else class="text-base  m-2 text-[#c75959] font-bold">Nenhum Professor Selecionado</h1>
          </CollapseContainer>
        </div>
      </div>

      <DataTable :thList="teacherThList" :tdKeys="teacherTdKeys" :selectableRow="true" :data="teachers"
        :isLoading="loadingData" @selectRowItemId="updateSelectedTeacher" />
      <DataTablePagination class="m-auto" v-if="pagination && teachers.length" :pagination="pagination"
        @setParams="setParams" />
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
import EditTeacher from "@/components/teacher/EditTeacher.vue"
import AdditionalInfoTeacher from "@/components/teacher/AdditionalInfoTeacher.vue";
import DataTable from "@/components/table/DataTable.vue";
import DataTablePagination from "@/components/table/DataTablePagination.vue";
import { teacherThList, teacherTdKeys } from "@/columns/ColumnsTeacher";
import { TeacherModel } from "@/models/TeacherModel";
import { getTeacher, getTeachers, TeacherPagination } from "@/requests/teacherRequests";
import PaginationModel from "@/models/PaginationModel";

interface Params {
  page?: number;
}

const router = useRouter();
const collapseAddTeacherChild = ref<InstanceType<typeof CollapseContainer>>();
const collapseEditTeacherChild = ref<InstanceType<typeof CollapseContainer>>();

const loadingData = ref<boolean>(true);

const teachers = ref<TeacherModel[]>([]);
const selectedTeacher = ref<TeacherModel>();
const selectedTeacherId = ref<number>();

const pagination = ref<PaginationModel>();
const params = ref<Params>(router.currentRoute.value.query);

watch(params, async function () {
  getTeachersData(params.value);
  updateRouteQueryParams(params.value);
}, { immediate: true });

watch(selectedTeacherId, async function () {
  if (selectedTeacherId.value) {
    try {
      const getTeacherResponse = await getTeacher(selectedTeacherId.value)
      selectedTeacher.value = getTeacherResponse.data;

      window.scrollTo({ top: 0, behavior: "smooth" });
      collapseEditTeacherChild.value?.forceOpen();
    } catch {
      //
    }
  }
});

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

function setParams(newParams: Params): void {
  params.value = { ...params.value, ...newParams };
}

function updateRouteQueryParams(params: Params): void {
  router.push({ query: params as LocationQuery });
}

function onAddTeacher(teacher: TeacherModel): void {
  setNewTeacher(teacher);
  collapseAddTeacherChild.value?.forceClose();
}

function onEditTeacher(updatedTeacher: TeacherModel): void {
  const teacher = teachers.value.find(teacher => teacher.id === updatedTeacher.id);
  if (teacher) Object.assign(teacher, updatedTeacher);
}

function setNewTeacher(teacher: TeacherModel): void {
  teachers.value = [teacher, ...teachers.value];
}

function updateSelectedTeacher(id: number): void {
  selectedTeacherId.value = id;
}
</script>
