<template>
    <button class="" @click="handleFormVisibility">
        <PlusIcon class="w-10 h-10 md:w-14 md:h-14" fill="white" v-if="!showForm" />
        <CancelIcon class="w-10 h-10" fill="white" v-else />
    </button>
    <div class="flex flex-col gap-1" v-if="showForm">
        <InputLabel text="Nome" track="course-lesson-name" />
        <form class="flex flex-col gap-2 md:flex-row md:items-center" @submit.prevent="onSubmit">
            <InputText id="course-lesson-name" v-model="courseLessonData.name" />
            <SubmitButton text="Adicionar" />
        </form>
    </div>
</template>

<script setup lang="ts">
import { ref, reactive, defineProps } from 'vue';
import { CourseModel } from '@/models/CourseModel';
import { CourseLessonAddModel, CourseLessonModel } from '@/models/CourseLessonModel';
import AddCourseLessonValidation from '@/validations/courseLesson/addCourseLesson';
import { addCourseLesson } from '@/requests/courseLessonRequests';
import InputLabel from '@/components/common/form/inputs/InputLabel.vue';
import InputText from '@/components/common/form/inputs/InputText.vue';
import PlusIcon from '@/icons/PlusIcon.vue';
import CancelIcon from '@/icons/CancelIcon.vue';
import SubmitButton from '@/components/common/form/SubmitButton.vue';

interface addCourseLessonProps {
    course: CourseModel;
    onAdd: (courseLesson: CourseLessonModel) => void;
}

const props = defineProps<addCourseLessonProps>();
const showForm = ref<boolean>(false);

const initialState: CourseLessonAddModel = {
    courseId: props.course.id,
    name: "",
};

const courseLessonData: CourseLessonAddModel = reactive(initialState);

async function onSubmit(): Promise<void> {
    try {
        new AddCourseLessonValidation(courseLessonData);

        const response = await addCourseLesson(courseLessonData);
        props.onAdd(response.data);
    } catch (error) {
        //
    }
}

function handleFormVisibility(): void {
    showForm.value = !showForm.value;
}

</script>
