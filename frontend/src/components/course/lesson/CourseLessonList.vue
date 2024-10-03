<template>
    <div class="flex flex-col gap-3 p-4 rounded-md bg-[#222D32]">
        <h2 class="text-xl md:text-2xl font-semibold text-white">Lições</h2>
        <div v-if="courseLessons.length" class="flex flex-col gap-3">
            <CourseLesson v-for="courseLesson in courseLessons" :courseLesson="courseLesson" :key="courseLesson.id" />
        </div>
        <h3 class="text-base md:text-lg text-green-600 font-bold" v-else>Não possui lições</h3>
        <AddCourseLesson :course="course" :onAdd="onAddCourseLesson" />
    </div>
</template>

<script setup lang="ts">
import { ref, defineProps, onMounted } from 'vue';
import { CourseModel } from '@/models/CourseModel';
import { CourseLessonModel } from '@/models/CourseLessonModel';
import { getCourseLessons } from '@/requests/courseRequests';
import AddCourseLesson from './AddCourseLesson.vue';
import CourseLesson from './CourseLesson.vue';

interface CourseLessonListProps {
    course: CourseModel;
}

const props = defineProps<CourseLessonListProps>();
const courseLessons = ref<CourseLessonModel[]>([]);

onMounted(async function () {
    const courseLessonsResponse = await getCourseLessons(props.course.id);
    courseLessons.value = courseLessonsResponse.data;
});

function onAddCourseLesson(courseLesson: CourseLessonModel): void {
    setNewCourseLesson(courseLesson);
}

function setNewCourseLesson(courseLesson: CourseLessonModel): void {
    courseLessons.value = [...courseLessons.value, courseLesson];
}
</script>