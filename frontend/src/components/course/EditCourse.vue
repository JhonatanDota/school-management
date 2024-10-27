<template>
    <form @submit.prevent="onSubmit" class="flex flex-col gap-3 p-4 rounded-md bg-[#222D32]">
        <InputContainer>
            <InputLabel text="Nome" track="name" />
            <InputText id="name" v-model="courseData.name" />
        </InputContainer>

        <InputContainer>
            <InputLabel text="Descrição" track="description" />
            <InputText id="description" v-model="courseData.description" />
        </InputContainer>

        <SubmitButton text="Editar" />
    </form>
</template>

<script setup lang="ts">
import { reactive, defineProps } from 'vue';
import { CourseModel, CourseEditModel } from '@/models/CourseModel';
import { editCourse } from '@/requests/courseRequests';
import { toast } from '@/utils/functions/toast';
import editCourseValidation from '@/validations/course/editCourse'
import InputContainer from '../common/form/inputs/InputContainer.vue';
import InputLabel from '../common/form/inputs/InputLabel.vue';
import InputText from '../common/form/inputs/InputText.vue';
import SubmitButton from '../common/form/SubmitButton.vue';

interface EditCourseProps {
    course: CourseModel
}

const props = defineProps<EditCourseProps>();

const courseData = reactive<CourseModel>(props.course);

async function onSubmit(): Promise<void> {
    try {
        const parsedCourseData = editCourseDataParser(courseData);

        new editCourseValidation(parsedCourseData);

        await editCourse(props.course.id, parsedCourseData);

        toast("Curso editado!");
    } catch (error) {
        //
    }
}

function editCourseDataParser(course: CourseModel): CourseEditModel {
    return {
        name: course.name,
        description: course.description,
    };
}

</script>