<template>
  <ContainerPage>
    <button class="w-7 h-7 md:w-10 md:h-10" @click="backToCoursesPage">
      <CircleArrowUp fill="#7745a5c2" class="w-full -rotate-90" />
    </button>

    <div class="flex flex-col gap-6" v-if="course">
      <TitlePage :title="`${course.name}`" />
      <EditCourse :course="course" />
    </div>

    <CourseDetailsSkeleton v-else />

  </ContainerPage>
</template>

<script setup lang="ts">
import { ref, onBeforeMount } from "vue";
import { RouteParams, useRoute, useRouter } from "vue-router";
import { getCourse } from "@/requests/courseRequests";
import { CourseModel } from "@/models/CourseModel";
import ContainerPage from "../ContainerPage.vue";
import TitlePage from "../TitlePage.vue";
import CircleArrowUp from "@/icons/CircleArrowUp.vue";
import CourseDetailsSkeleton from "@/skeletons/CourseDetailsSkeleton.vue"
import EditCourse from "@/components/course/EditCourse.vue";

const route = useRoute();
const router = useRouter();

const course = ref<CourseModel>();

onBeforeMount(function () {
  const params: RouteParams = route.params;
  const courseId: number = Number(params.id);

  if (courseId) getCourseData(courseId);
});

async function getCourseData(id: number): Promise<void> {
  try {
    const response = await getCourse(id);

    course.value = response.data;
  } catch {
    //
  }
}

function backToCoursesPage(): void {
  router.push("/courses");
}
</script>