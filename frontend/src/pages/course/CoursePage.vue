<template>
  <ContainerPage>
    <TitlePage title="Cursos" />
    <div class="flex flex-col gap-3">
      <CollapseContainer class="w-full md:w-2/3 bg-[#222D32]" title="Adicionar Curso">
        <div class="pt-2 md:pt-5">
          <AddCourse :onAdd="setNewCourse" />
        </div>
      </CollapseContainer>
      <DataTable :thList="courseThList" :tdKeys="courseTdKeys" :selectableRow="true" @selectRowItemId="selectCourse"
        :data="courses" :isLoading="loadingData" />
    </div>
  </ContainerPage>
</template>

<script setup lang="ts">
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import { CourseModel } from "@/models/CourseModel";
import { courseThList, courseTdKeys } from "@/columns/ColumnsCourse";
import { getCourses, CoursePagination } from "@/requests/courseRequests";
import CollapseContainer from "@/components/CollapseContainer.vue";
import ContainerPage from "../ContainerPage.vue";
import TitlePage from "../TitlePage.vue";
import DataTable from "@/components/table/DataTable.vue";
import AddCourse from "@/components/course/AddCourse.vue";

const router = useRouter();
const courses = ref<CourseModel[]>([]);
const loadingData = ref<boolean>(true);

onMounted(() => {
  getCoursesData();
});

async function getCoursesData(): Promise<void> {
  loadingData.value = true;

  try {
    const response = await getCourses();
    const responseData: CoursePagination = response.data;

    courses.value = responseData.data;
  } catch {
    //
  } finally {
    loadingData.value = false;
  }
}

function selectCourse(id: number): void {
  router.push(`/courses/${id}/`);
}

function setNewCourse(course: CourseModel): void {
  courses.value = [course, ...courses.value];
}

</script>