<template>
    <div class="flex flex-col gap-3 p-4 rounded-md bg-[#222D32]">
        <h2 class="text-xl md:text-2xl font-semibold text-white">Lições</h2>
        <SlickList axis="y" v-if="courseLessons.length" v-model:list="courseLessons" class="flex flex-col gap-3"
            :distance=10 @sort-end="onDragEnd">
            <SlickItem v-for="(courseLesson, index) in courseLessons" :key="courseLesson.id" :index="index">
                <CourseLesson :courseLesson="courseLesson" />
            </SlickItem>
        </SlickList>
        <h3 class="text-base md:text-lg text-green-600 font-bold" v-else>Não possui lições</h3>
        <AddCourseLesson :course="course" :onAdd="onAddCourseLesson" />
    </div>
</template>

<script setup lang="ts">
import { ref, defineProps, onMounted } from 'vue';
import { SlickList, SlickItem } from 'vue-slicksort';
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

async function reorderCourseLessons(): Promise<void> {
    //
}

function onAddCourseLesson(courseLesson: CourseLessonModel): void {
    setNewCourseLesson(courseLesson);
}

function setNewCourseLesson(courseLesson: CourseLessonModel): void {
    courseLessons.value = [...courseLessons.value, courseLesson];
}

function onDragEnd({ newIndex, oldIndex }: { newIndex: number, oldIndex: number }): void {
    if (newIndex !== oldIndex) {
        reorderCourseLessons();
    }
}
</script>