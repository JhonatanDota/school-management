<template>
    <div class="flex flex-col gap-3 p-4 rounded-md bg-[#222D32]">
        <h2 class="text-xl md:text-2xl font-semibold text-white">Lições</h2>

        <SlickList axis="y" v-if="courseLessons.length" v-model:list="courseLessons" @sort-end="onDragEnd"
            class="flex flex-col gap-3" :distance=10>
            <SlickItem v-for="(courseLesson, index) in courseLessons" :key="courseLesson.id" :index="index">
                <CourseLesson :courseLesson="courseLesson" @edit="openEditModal" />
            </SlickItem>
        </SlickList>

        <h3 class="text-base md:text-lg text-green-600 font-bold" v-else>Não possui lições</h3>

        <AddCourseLesson :course="course" :onAdd="onAddCourseLesson" />

        <EditLessonModal v-if="selectedCourseLesson" v-model="isEditModalOpen" :courseLesson="selectedCourseLesson"
            @updateCourseLesson="updateCourseLesson" />
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
import EditLessonModal from './modals/EditLessonModal.vue';

interface CourseLessonListProps {
    course: CourseModel;
}

const props = defineProps<CourseLessonListProps>();
const courseLessons = ref<CourseLessonModel[]>([]);
const isEditModalOpen = ref(false);
const selectedCourseLesson = ref<CourseLessonModel | null>(null);

onMounted(async function () {
    const courseLessonsResponse = await getCourseLessons(props.course.id);
    courseLessons.value = courseLessonsResponse.data;
});

async function reorderCourseLessons(): Promise<void> {
    const courseLessonIds: number[] = courseLessons.value.map((courseLesson) => courseLesson.id);
    try {
        await reorderCourseLessonsRequest(props.course.id, courseLessonIds);
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

function openEditModal(courseLesson: CourseLessonModel) {
    selectedCourseLesson.value = courseLesson;
    isEditModalOpen.value = true;
}

function updateCourseLesson(newCourseLesson: CourseLessonModel): void {
    courseLessons.value = courseLessons.value.map((courseLesson) => courseLesson.id === newCourseLesson.id ? newCourseLesson : courseLesson);
}
</script>
