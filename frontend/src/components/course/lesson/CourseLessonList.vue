<template>
    <div class="flex flex-col gap-3 p-4 rounded-md bg-[#222D32]">
        <h2 class="text-xl md:text-2xl font-semibold text-white">Lições</h2>
        <SlickList axis="y" v-if="courseLessons.length" v-model:list="courseLessons" @sort-end="onDragEnd"
            class="flex flex-col gap-3" :distance=10>
            <SlickItem v-for="(courseLesson, index) in courseLessons" :key="courseLesson.id" :index="index">
                <CourseLesson :courseLesson="courseLesson" />
            </SlickItem>
        </SlickList>
        <h3 class="text-base md:text-lg text-green-600 font-bold" v-else>Não possui lições</h3>
        <AddCourseLesson :course="course" :onAdd="onAddCourseLesson" />
    </div>
</template>

<script setup lang="ts">
import { ref, defineProps, onMounted, nextTick } from 'vue';
import { SlickList, SlickItem } from 'vue-slicksort';
import { CourseModel } from '@/models/CourseModel';
import { CourseLessonModel } from '@/models/CourseLessonModel';
import { getCourseLessons, reorderCourseLessons as reorderCourseLessonsRequest } from '@/requests/courseRequests';
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
    const courseLessonIds: number[] = courseLessons.value.map((courseLesson) => courseLesson.id);

    try {
        await reorderCourseLessonsRequest(
            props.course.id,
            courseLessonIds,
        );

    } catch (error) {
        //
    }
}

function onAddCourseLesson(courseLesson: CourseLessonModel): void {
    setNewCourseLesson(courseLesson);
}

function setNewCourseLesson(courseLesson: CourseLessonModel): void {
    courseLessons.value = [...courseLessons.value, courseLesson];
}

function onDragEnd({ newIndex, oldIndex }: { newIndex: number, oldIndex: number }): void {
    if (newIndex !== oldIndex) {
        nextTick(() => {
            reorderCourseLessons();
        });
    }
}
</script>